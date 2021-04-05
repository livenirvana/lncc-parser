import argparse
import os
import sys

from subprocess import Popen, PIPE


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--directory', type=str,)
    parser.add_argument('--write', action='store_true', help='Write html files')

    args = parser.parse_args()

    for filename in os.listdir(args.directory):
        if filename.lower().endswith('.php'):
            try:
                filepath = os.path.join(args.directory, filename)

                # run php get output
                process = Popen(['php', '-f', filepath], cwd=args.directory, stdin=PIPE, stdout=PIPE, stderr=PIPE)
                output = process.stdout.read()
            except:
                print('error', filename)
            else:

                if args.write:
                    write_filename = filename.replace('php', 'html')

                    write_filepath = os.path.join(args.directory, write_filename)

                    writer = open(write_filepath, 'wb')
                    writer.write(output)
                    writer.close()

                sys.stdout.write('.')
                sys.stdout.flush()
    else:
        sys.stdout.write('\n')

if __name__ == "__main__":
    main()