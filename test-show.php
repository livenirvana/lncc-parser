<?php

# Check that JSON format is valid here:
# https://codebeautify.org/jsonvalidator
#
# Most common issue is missing commas, or having commas at the end of lists (trailing commas).
# Trailing commas are not allowed.
# Ping Nick with any validation questions. If JSON isn't valid the page won't work.

$payload = <<<'JSON'

{
    "year": "1993",
    "month": "10",
    "day": "18",
    "venue": "Veterans Memorial Coliseum (Arizona State Fair)",
    "city": "Phoenix",
    "state": "AZ",
    "country": "US",
    "band": [
        {
            "members": [
                {
                    "name": "Kurt Cobain ",
                    "duty": "vocals, guitar"
                },
                {
                    "name": "Krist Novoselic ",
                    "duty": "bass"
                },
                {
                    "name": "Dave Grohl ",
                    "duty": "drums, backing vocals"
                },
                {
                    "name": "Pat Smear ",
                    "duty": "guitar"
                },
                {
                    "name": "Lori Goldston ",
                    "duty": "cello"
                }
            ],
            "type": "group",
            "name": "NIRVANA"
        }
    ],
    "crew": [
        {
            "name": "Alex MacLeod",
            "duty": "tour manager"
        },
        {
            "name": "Jeff Mason",
            "duty": "production manager"
        },
        {
            "name": "Kelly Nase",
            "duty": "tour accountant"
        },
        {
            "name": "Susanne Sasic",
            "duty": "lighting designer"
        },
        {
            "name": "Craig Overbay",
            "duty": "sound engineer"
        },
        {
            "name": "Ian Beveridge",
            "duty": "monitor engineer"
        },
        {
            "name": "Jim Vincent",
            "duty": "guitar technician"
        },
        {
            "name": "John Duncan",
            "duty": "guitar technician"
        },
        {
            "name": "Jimmy Swanson",
            "duty": "drum technician"
        },
        {
            "name": "Ed Swink",
            "duty": "stage manager"
        },
        {
            "name": "Dave Stevens",
            "duty": "Pro Show sound crew"
        },
        {
            "name": "Allan Bagley",
            "duty": "Pro Show sound crew"
        },
        {
            "name": "Tom Pfaeffle",
            "duty": "Pro Show sound crew"
        },
        {
            "name": "Spike Brant",
            "duty": "LSD lighting crew"
        },
        {
            "name": "Mike Lamb",
            "duty": "LSD lighting crew"
        },
        {
            "name": "Pat Connolly",
            "duty": "LSD lighting crew"
        },
        {
            "name": "Gary Vaspol",
            "duty": "LSD lighting crew"
        }
    ],
    "buyer": {
        "names": [
            "Dan Zelisko",
            "Terry Burke"
        ],
        "company": "Evening Star Productions"
    },
    "schedule": [
        {
            "event": "Load In",
            "time": "09:00"
        },
        {
            "event": "Soundcheck",
            "time": "14:00"
        },
        {
            "event": "Doors",
            "time": "17:00"
        },
        {
            "event": "Mudhoney Showtime",
            "time": "18:00"
        },
        {
            "event": "NIRVANA Showtime",
            "time": "19:00"
        }
    ],
    "soundcheck": [
        {
            "type": "song",
            "text": "Milk It",
            "notes": []
        }
    ],
    "soundcheck_incomplete": true,
    "set": [
        {
            "type": "song",
            "text": "Radio Friendly Unit Shifter",
            "notes": []
        },
        {
            "type": "song",
            "text": "Drain You",
            "notes": []
        },
        {
            "type": "song",
            "text": "Breed",
            "notes": []
        },
        {
            "type": "song",
            "text": "Serve The Servants",
            "notes": []
        },
        {
            "type": "song",
            "text": "About A Girl",
            "notes": []
        },
        {
            "type": "song",
            "text": "Heart-Shaped Box",
            "notes": []
        },
        {
            "type": "song",
            "text": "Sliver",
            "notes": []
        },
        {
            "type": "song",
            "text": "Dumb",
            "notes": []
        },
        {
            "type": "song",
            "text": "In Bloom",
            "notes": []
        },
        {
            "type": "song",
            "text": "Come As You Are",
            "notes": []
        },
        {
            "type": "song",
            "text": "Lithium",
            "notes": []
        },
        {
            "type": "song",
            "text": "Pennyroyal Tea",
            "notes": []
        },
        {
            "type": "song",
            "text": "School",
            "notes": []
        },
        {
            "type": "song",
            "text": "Polly",
            "notes": [
                "acoustic"
            ]
        },
        {
            "type": "song",
            "text": "Milk It",
            "notes": []
        },
        {
            "type": "song",
            "text": "Rape Me",
            "notes": []
        },
        {
            "type": "song",
            "text": "Territorial Pissings",
            "notes": []
        },
        {
            "type": "song",
            "text": "Smells Like Teen Spirit",
            "notes": []
        },
        {
            "type": "song",
            "text": "All Apologies",
            "notes": []
        },
        {
            "type": "song",
            "text": "Blew",
            "notes": []
        },
        {
            "type": "song",
            "text": "Endless, Nameless",
            "notes": []
        }
    ],
    "set_incomplete": false,
    "transmission": {},
    "rehearsel_circulating_sources": [],
    "circulating_sources": [
        {
            "name": "AUD #1",
            "complete": false,
            "equipment": "Realistic Miniature PZM > Sony TCD-D7",
            "generation": "DAT(M) > FLAC",
            "video-generation": null,
            "audio-generation": null,
            "length-sound": "88 min / 8.5",
            "notes": [
                "In June 2007 the master tape was circulated.",
                "\"Radio Friendly Unit Shifter\" cuts in."
            ]
        },
        {
            "name": "AUD #2",
            "complete": true,
            "equipment": "Aiwa (supplied) > Aiwa HS-JS475",
            "generation": "ANA(M) > FLAC",
            "video-generation": null,
            "audio-generation": null,
            "length-sound": "87 min / 8.0",
            "notes": [
                "In January 2012 the master tape was circulated.",
                "The intro to \"Radio Friendly Unit Shifter\" cuts in."
            ]
        },
        {
            "name": "AUD #3",
            "complete": true,
            "equipment": "unknown > unknown",
            "generation": "ANA(1) > FLAC",
            "video-generation": null,
            "audio-generation": null,
            "length-sound": "89:51 min / ?",
            "notes": [
                "Surfaced December 2020",
                "Has dropouts during \"Drain You\" and \"Territorial Pissings.\"",
                "Has a cut in \"All Apologies\""
            ]
        },
        {
            "name": "PRO #1",
            "complete": false,
            "equipment": "Soundboard > Unknown",
            "generation": "VHS(x) > MP4",
            "video-generation": null,
            "audio-generation": null,
            "length-sound": "16:41 min / ??",
            "notes": [
                "Single camera video with soundboard audio in the right channel and audience audio in the left, shot by MTV.",
                "Includes Pre-show footage, \"Drain You\", \"Serve The Servants\", \"Sliver\", \"Pennyroyal Tea\", \"School\" (cut)."
            ]
        }
    ],
    "uncirculated_sources": [],
    "notes": [
        "The crowd reportedly booed and chanted for Nirvana during Mudhoney's opening set, prompting Kurt to chastise the crowd at the beginning of Nirvana's set, according to an attendee.",
        "After \"Polly\", Krist sang a bit of Aerosmith's \"Dream On\", followed by Kurt singing a bit of the 4 Non Blondes song \"What's Up\".",
        "At some point, Kurt smashed one of the angel mannequins and also dove into one of the pits and came out with his guitar."
    ],
    "press": [],
    "memorabilia": [
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_01.jpg",
            "caption": "Advert"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_02.jpg",
            "caption": "Advert"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_03.jpg",
            "caption": "Advert"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_04.jpg",
            "caption": "Handwritten setlist"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_05.jpg",
            "caption": "Advert"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_06.jpg",
            "caption": "Advert"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_07.jpg",
            "caption": "Nirvana's tour itinerary"
        }
    ],
    "images": [
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_001.jpg",
            "caption": "Photo by Craig Macnaughton"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_002.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_003.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_004.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_005.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_006.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_007.jpg",
            "caption": "Photo by Lissa Wales"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_008.jpg",
            "caption": "Photo by Jeff Kida"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_009.jpg",
            "caption": "Photo by Kevin Bishop"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_010.jpg",
            "caption": "Photo by Kevin Bishop"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_011.jpg",
            "caption": "Photo by Kevin Bishop"
        },
        {
            "url": "/concerts/images/1993/1993-10-18/1993-10-18_012.jpg",
            "caption": "Photo by Kevin Bishop"
        }
    ],
    "navigation": {
        "previous": "93-09-25",
        "next": "93-10-19"
    },
    "graph": {
        "bleach": "3",
        "nevermind": "9",
        "inutero": "8",
        "non": "1"
    }
}

JSON;

require_once('../includes/template.php');
?>