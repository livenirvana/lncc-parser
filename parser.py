import argparse, json, os, re, sys

from pathlib import Path

from bs4 import BeautifulSoup
from bs4.element import Tag


states = [
    'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL',
    'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME',
    'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH',
    'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI',
    'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI',
    'WY'
]

PHP_TEMPLATE_PRE = '''<?php

# Check that JSON format is valid here:
# https://codebeautify.org/jsonvalidator
#
# Most common issue is missing commas, or having commas at the end of lists (trailing commas).
# Trailing commas are not allowed.
# Ping Nick with any validation questions. If JSON isn't valid the page won't work.

$payload = <<<'JSON'

'''

PHP_TEMPLATE_POST = '''

JSON;

require_once('../includes/template.php');
?>'''


def parse(filepath):
    f = open(filepath, 'r')

    filename = os.path.basename(filepath)

    payload = {}

    year, month, day = filename[:8].split('-')
    year = '19' + year

    # Date
    payload['year'] = year

    try:
        if int(month) >= 1 and int(month) <= 12:
            payload['month'] = month
        else:
            payload['month'] = 'xx'
    except ValueError:
        payload['month'] = 'xx'

    payload['day'] = day

    html = f.read()
    soup = BeautifulSoup(html, 'html.parser')

    title_text = soup.h1.small.text

    if '-' in title_text:
        title = title_text.split('-', 1)[1].split(',')
    else:
        title = title_text.split(',')

    title = [t.strip() for t in title]

    if title[-1].lower() == 'us' and title[-2] in states:
        # US location
        payload['venue'] = ', '.join(title[:-3])
        payload['city'] = title[-3]
        payload['state'] = title[-2]
        payload['country'] = title[-1]

    elif title[-1].lower() == 'ca':
        # Canada location
        payload['venue'] = ', '.join(title[:-3])
        payload['city'] = title[-3]
        payload['state'] = title[-2]
        payload['country'] = title[-1]

    else:
        # City/Country
        payload['venue'] = ', '.join(title[:-2])
        payload['city'] = title[-2]
        payload['state'] = None
        payload['country'] = title[-1]

    def parse_duty(text):
        try:
            return re.search(r'\(([\w&,/ -]+)\)', text).group(1)
        except AttributeError:
            # No duty listed
            return ''

    # Band members
    payload['band'] = []
    for item in soup.find(text='Artist').findNext('ul').findChildren('li' , recursive=False):
        if item.ul:
            group_name = item.contents[0].replace('\n', '').strip()
            group_members = []

            for nirvana_member in item.ul.find_all('li'):
                group_members.append(
                    {'name': nirvana_member.text.split('(')[0].strip(), 'duty': parse_duty(nirvana_member.text)}
                )
            group = {'members': group_members, 'type': 'group', 'name': group_name}
            payload['band'].append(group)
        else:
            payload['band'].append(
                {'name': item.text.split('(')[0].strip(), 'duty': parse_duty(item.text), 'type': 'person'}
            )

    # Crew members
    payload['crew'] = []
    for item in soup.find(text='Crew').findNext('ul').find_all('li'):
        if 'no info' in item.text.lower():
            break

        name = item.text.split('(')[0]
        duty = parse_duty(item.text)

        payload['crew'].append({'name': name.strip(), 'duty': duty})

    # Buyer info
    payload['buyer'] = {'names': []}
    buyer_li = soup.find(text='Buyer').findNext('ul').li
    if buyer_li.ul:
        payload['buyer']['company'] = buyer_li.contents[0].replace('\n', '').strip()
        # With company
        for item in buyer_li.ul.find_all('li'):
            if item.text.lower().strip() == 'no info':
                break
            payload['buyer']['names'].append(item.text)
    else:
        # No company
        for item in soup.find(text='Buyer').findNext('ul').find_all('li'):
            if 'no info' in item.text.lower():
                break

            payload['buyer']['names'].append(item.text)

    # Schedule
    payload['schedule'] = []
    schedule_header = soup.find_all(lambda tag: tag.name == 'h2' and 'schedule' in tag.get_text().lower())[0]
    try:
        for child in schedule_header.findNext('dl').children:
            if isinstance(child, Tag) and child.name == 'dt':
                event = child.text
                time = child.find_next_sibling()

                if time.text == '…:…':
                    time_text = None
                else:
                    time_text = time.text

                if isinstance(time, Tag) and time.name == 'dd':
                    payload['schedule'].append(
                        {'event': event, 'time': time_text}
                    )
    except AttributeError:
        # No schedule info
        pass

    def do_soundcheck_set(child):
        notes = []

        if child.find('span', {'class': 'label'}):
            # song has notes
            for note in child.find_all('span', {'class': 'label'}):
                notes.append(note.text)

        if child.find('span', {'class': 'green'}):
            # Song
            return {'type': 'song', 'text': child.span.text, 'notes': notes}
        elif child.find('aside', {'class': 'jam'}):
            # Jam
            return {'type': 'jam', 'text': child.text, 'notes': notes}
        elif child.find('aside', {'class': 'banter'}):
            # Banter

            text = child.aside.q.text
            unicode_re = re.compile(r'^([\w[] ]+) *- *', re.U)
            try:
                person = unicode_re.match(child.aside.text).group(1)
            except AttributeError:
                person = child.aside.contents[0].replace('-', '').strip()

            return {'type': 'banter', 'text': text, 'person': person}

    # Soundcheck
    soundcheck_header = soup.find_all(lambda tag: tag.name == 'h2' and 'soundcheck' in tag.get_text().lower())[0]
    payload['soundcheck'] = []
    payload['soundcheck_incomplete'] = bool('incomplete' in soundcheck_header.text.lower())
    for child in soundcheck_header.findNext('ol').find_all('li'):
        if 'no info' in child.text.lower():
            break

        result = do_soundcheck_set(child)
        if result:
            payload['soundcheck'].append(result)

    # Set
    set_header = soup.find_all(lambda tag: tag.name == 'h2' and 'set' in tag.get_text().lower())[0]
    payload['set'] = []
    payload['set_incomplete'] = bool('incomplete' in set_header.text.lower())
    for child in set_header.findNext('ol').find_all('li'):
        if 'no info' in child.text.lower():
            break

        result = do_soundcheck_set(child)
        if result:
            payload['set'].append(result)

    # Transmission
    payload['transmission'] = {}
    try:
        transmission_li = soup.find(text='Transmission').findNext('ul').li
        transmission_info = transmission_li.contents[0].strip()
        if transmission_info.endswith(','):
            # Remove trailing comma
            transmission_info = transmission_info[:-1]

        payload['transmission']['info'] = transmission_info
        payload['transmission']['show'] = transmission_li.cite.text
    except AttributeError:
        # No transmission
        pass

    def parse_sources(child):
        # Only get circulating
        if not 'green' in child.span['class']:
            return

        name = child.span.abbr.text + child.span.text.replace(child.span.abbr.text, '')
        name = name.replace('incomplete', '')
        name = name.strip()

        incomplete = bool('incomplete' in child.text)

        dl = child.find_next_sibling()

        notes = []

        generation = None
        video_generation = None
        audio_generation = None

        for dl_child in dl.children:
            if isinstance(dl_child, Tag):
                if 'equipment:' in dl_child.text.lower():
                    equipment = dl_child.find_next_sibling().text
                elif 'lowest generation' in dl_child.text.lower():
                    generation = dl_child.find_next_sibling().text
                elif 'lowest audio generation' in dl_child.text.lower():
                    audio_generation = dl_child.find_next_sibling().text
                elif 'lowest video generation' in dl_child.text.lower():
                    video_generation = dl_child.find_next_sibling().text
                elif 'length' in dl_child.text.lower() and 'sound' in dl_child.text.lower() and '/' in dl_child.text.lower():
                    length = dl_child.find_next_sibling().text
                elif 'note' in dl_child.text.lower():

                    note_loop = dl_child.find_next_sibling()
                    while True:
                        if not note_loop:
                            break
                        if isinstance(note_loop, Tag) and note_loop.name == 'dd':
                            notes.append(note_loop.text.strip())
                            note_loop = note_loop.find_next_sibling()

        return {
            'name': name,
            'complete': not incomplete,
            'equipment': equipment,
            'generation': generation,
            'video-generation': video_generation,
            'audio-generation': audio_generation,
            'length-sound': length,
            'notes': notes
        }

    # Does this show have both rehearsel and normal sources?
    has_rehearsel_sources = bool(
        len(soup.find_all(lambda tag: tag.name == 'h2' and 'circulating recordings' in tag.get_text().lower())) == 2
    )

    payload['rehearsel_circulating_sources'] = []
    payload['circulating_sources'] = []

    if not has_rehearsel_sources:
        # Circulating recordings
        for child in soup.find(name='h2', text='Circulating Recordings').parent.find_all('h5', {'class': 'source-title'}):
            source = parse_sources(child)

            if source:
                payload['circulating_sources'].append(source)
    else:
        # Rehearsel circulating recordings
        for child in soup.find(name='h2', text='Soundcheck/Dress Rehearsal Circulating Recordings').parent.find_all('h5', {'class': 'source-title'}):
            source = parse_sources(child)

            if source:
                payload['rehearsel_circulating_sources'].append(source)

        # Normal circulating recordings
        for child in soup.find(name='h2', text='Night Show Circulating Recordings').parent.find_all('h5', {'class': 'source-title'}):
            source = parse_sources(child)

            if source:
                payload['circulating_sources'].append(source)

    # Uncirculated recordings
    payload['uncirculated_sources'] = []
    for child in soup.find(name='h2', text='Uncirculated Recordings').parent.find_all('h5', {'class': 'source-title'}):

        # Only get circulating
        if not 'red' in child.span['class']:
            continue

        name = child.span.abbr.text + child.span.text.replace(child.span.abbr.text, '')
        name = name.strip()

        note = child.find_next_sibling().text

        payload['uncirculated_sources'].append(
            {'name': name, 'note': note}
        )

    # Notes
    payload['notes'] = []
    for child in soup.find(name='h2', text='Notes').findNext('ul').find_all('li'):
        if 'no info' in child.text.lower():
            break

        payload['notes'].append(child.text.strip())

    # Press
    payload['press'] = []
    for child in soup.find(name='h2', text='Press Reviews').findNext('ul').find_all('li'):
        if 'no info' in child.text.lower() or '…' in child.text.lower():
            break

        if not child.a:
            break

        payload['press'].append(
            {'text': child.a.text, 'url': child.a['href']}
        )

    # Memorabilia
    payload['memorabilia'] = []
    try:
        memorabilia_header = soup.find_all(lambda tag: tag.name == 'h2' and 'memorabilia' in tag.get_text().lower())[0]
    except IndexError:
        memorabilia_header = None

    if memorabilia_header:
        for img in memorabilia_header.findNext('div').find_all('img'):
            payload['memorabilia'].append(
                {'url': img['src'], 'caption': img['data-caption']}
            )

    # Images
    payload['images'] = []
    if soup.find(name='h2', text='Images'):
        for img in soup.find(name='h2', text='Images').findNext('div').find_all('img'):
            payload['images'].append(
                {'url': img['src'], 'caption': img['data-caption']}
                )

    # Navigation
    payload['navigation'] = {}
    try:
        payload['navigation']['previous'] = soup.find('ul', {'class': 'pager'}).find_all('li')[0].a['href'].replace('.php', '')
        payload['navigation']['next'] = soup.find('ul', {'class': 'pager'}).find_all('li')[1].a['href'].replace('.php', '')
    except (KeyError, IndexError):
        pass

    payload['graph'] = {}

    payload['graph']['bleach'] = re.search(r"Bleach material',\s*(\d+)", html).group(1)
    payload['graph']['nevermind'] = re.search(r"Nevermind material',\s*(\d+)", html).group(1)
    payload['graph']['inutero'] = re.search(r"In Utero material',\s*(\d+)", html).group(1)
    payload['graph']['non'] = re.search(r"Non-album material',\s*(\d+)", html).group(1)

    f.close()

    return payload


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--input-directory', type=str,)
    parser.add_argument('--output-directory', type=str, nargs='?', default=None)
    parser.add_argument('--filename', type=str)
    parser.add_argument('--write-json', action='store_true', help='Write json files')
    parser.add_argument('--write-php', action='store_true', help='Write php files')

    args = parser.parse_args()

    if not args.input_directory and not args.filename:
        raise Exception('Input directory or filename required')

    if (args.write_json or args.write_php) and not args.output_directory:
        raise Exception('Output directory required for writing.')

    if args.filename:
        parse(args.filename)
        sys.stdout.write('.\n')
    else:
        for filename in os.listdir(args.input_directory):
            if filename.lower().endswith('.php'):
                try:
                    filepath = os.path.join(args.input_directory, filename)
                    parsed_data = parse(filepath)
                except:
                    print('error', filename)
                else:

                    if args.write_json or args.write_php:

                        Path(args.output_directory).mkdir(parents=True, exist_ok=True)

                        if args.write_json:
                            write_filename = filename.replace('php', 'json')
                        elif args.write_php:
                            write_filename = filename

                        write_filepath = os.path.join(args.output_directory, write_filename)

                        writer = open(write_filepath, 'w')

                        if args.write_php:
                            writer.write(PHP_TEMPLATE_PRE)

                        json.dump(parsed_data, writer, indent=4, ensure_ascii=False)

                        if args.write_php:
                            writer.write(PHP_TEMPLATE_POST)

                        writer.close()

                    sys.stdout.write('.')
                    sys.stdout.flush()
        else:
            sys.stdout.write('\n')

if __name__ == "__main__":
    main()