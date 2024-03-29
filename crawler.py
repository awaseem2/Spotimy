import sys
import spotipy
import spotipy.util as util

#change later
#https://spotipy.readthedocs.io/en/latest/
#$env:SPOTIPY_REDIRECT_URI="https://www.spotify.com/us/"
#$env:SPOTIPY_CLIENT_SECRET="5a312dc3c53a4249a46a557accc22ac9"
#$env:SPOTIPY_CLIENT_ID="4f657b938eed4221b0a27491a8291ff4"
'''
util.prompt_for_user_token('vhagi4rl4jn7rwmtzm61ohixx', 'user-library-read', 
    client_id = '352752c21e5344f7b1e32cb88b43d5b1',
    client_secret = '7325c1cc61e149bc9601f3031d602ce4',
    redirect_uri = 'https://www.spotify.com/us/')
'''

artists_to_add = []
albums_to_add = []

def init_artist_ids():
    artist_ids['5 Seconds of Summer'] = 1
    artist_ids['Fall Out Boy'] = 2
    artist_ids['Lizzo'] = 3
    artist_ids['Kendrick Lamar'] = 4
    artist_ids['Louis Tomlinson'] = 5
    artist_ids['Harry Styles'] = 6
    artist_ids['Niall Horan'] = 7
    artist_ids['Zayn Malik'] = 8
    artist_ids['Demi Lovato'] = 9
    artist_ids['Grey'] = 10
    artist_ids['Khalid'] = 11
    artist_ids['KAMAUU'] = 12
    artist_ids['Kanye West'] = 13
    artist_ids['Mýa'] = 14
    artist_ids['Stephanie Poetri'] = 15
    artist_ids['The Cab'] = 16
    artist_ids['88rising'] = 17
    artist_ids['CHUNG HA'] = 18
    artist_ids['Allan Kingdom'] = 19
    artist_ids['ROMderful'] = 20
    artist_ids['RINI'] = 21
    artist_ids['Panic! At The Disco'] = 22
    artist_ids['Vulfpeck'] = 23
    artist_ids['UMI'] = 24
    artist_ids['Jorja Smith'] = 25
    artist_ids['Jessie Reyez'] = 26
    artist_ids['BTS'] = 27
    artist_ids['Jhené Aiko'] = 28
    artist_ids['Wifisfuneral'] = 29
    artist_ids['BROCKHAMPTON'] = 30
    artist_ids['Jaden'] = 31
    artist_ids['808INK'] = 32
    artist_ids['Strawberry Girls'] = 33
    artist_ids['Tsu Surf'] = 34
    artist_ids['Ginuwine'] = 35
    artist_ids['Mario Winans'] = 36
    artist_ids['Tyler, The Creator'] = 37
    artist_ids['3OH!3'] = 38
    artist_ids['AFI'] = 39
    artist_ids['Aminé'] = 40
    artist_ids['Doja Cat'] = 41
    artist_ids['Monica'] = 42
    artist_ids['Cage The Elephant'] = 43
    artist_ids['Nirvana'] = 44
    artist_ids['Passion Pit'] = 45
    artist_ids['alt-J'] = 46
    artist_ids['Maroon 5'] = 47

def init_album_ids():
    album_ids['5 Seconds of Summer'] = 1
    album_ids['Teeth'] = 2
    album_ids['American Beauty/American Psycho'] = 3
    album_ids['Cuz I Love You'] = 4
    album_ids['Folie a Deux'] = 5
    album_ids['DAMN'] = 6
    album_ids['Confident'] = 7
    album_ids['Grey'] = 8
    album_ids['American Teen'] = 9
    album_ids['A Gorgeous Fortune EP'] = 10
    album_ids['JESUS IS KING'] = 11
    album_ids['Moodring'] = 12
    album_ids['I Love You 3000'] = 13
    album_ids['Symphony Soldier'] = 14
    album_ids['Whisper War'] = 15
    album_ids['Head In The Clouds II'] = 16
    album_ids['Gotta Go'] = 17
    album_ids['Flourishing'] = 18
    album_ids['LINES'] = 19
    album_ids['SummerTimeTing (feat. Mayzin, Emmavie & KayFaraway)'] = 20
    album_ids['For the Last Time (feat. Snaggle Owky)'] = 21
    album_ids['Vices & Virtues'] = 22
    album_ids['Thrill of the Arts'] = 23
    album_ids['FRIENDZONE'] = 24
    album_ids['Lost & Found'] = 25
    album_ids['The One'] = 26
    album_ids['Be Honest (feat. Burna Boy) (acoustic)'] = 27
    album_ids['CRAZY'] = 28
    album_ids['MAP OF THE SOUL : PERSONA'] = 29
    album_ids['None Of Your Concern'] = 30
    album_ids['run?'] = 31
    album_ids['SATURATION'] = 32
    album_ids['SYRE'] = 33
    album_ids['When I'm About, You'll Know, Pt. 2'] = 34
    album_ids['American Graffiti'] = 35
    album_ids['Newark Mixtape'] = 36
    album_ids['The Life'] = 37
    album_ids['Hurt No More'] = 38
    album_ids['IGOR'] = 39
    album_ids['WANT'] = 40
    album_ids['DECEMBERUNDERGROUND'] = 41
    album_ids['ONEPOINTFIVE'] = 42
    album_ids['Juicy'] = 43
    album_ids['Commitment'] = 44
    album_ids['Melophobia'] = 45
    album_ids['Nevermind (Remastered)'] = 46
    album_ids['Gossamer'] = 47
    album_ids['This Is All Yours'] = 48
    album_ids['Be Honest (feat. Burna Boy)'] = 49
    album_ids['Songs About Jane'] = 50


#artist = name, id_ = spotify's artist id, not our artist id
def get_artist_id(artist, id_):
    if artist in artist_ids:
        return artist_ids[artist]
    new_id = len(artist_ids) + 1

    popularity = sp.artist(id_)['popularity']
    genre = sp.artist(id_)['genres'][0] if len(sp.artist(id_)['genres']) > 0 else "Pop"
    insert = "INSERT INTO `Artist`(`Artist_ID`, `Artist_Name`, `Artist_Popularity`, `Artist_Genre`) VALUES ({},'{}',{},'{}')".format(new_id, artist, popularity, genre)
    
    artists.append(insert)
    artists_to_add.append("artist_ids['" + artist + "'] = " + str(new_id))
    artist_ids[artist] = new_id
    return new_id

def get_album_id(album, id_, artist, art_id_):
    if album in album_ids:
        return album_ids[album]
    new_id = len(album_ids) + 1

    genre = sp.album(id_)['genres'][0] if (len(sp.album(id_)['genres']) > 0) else "Pop"
    artist_id = get_artist_id(artist, art_id_)
    insert = "INSERT INTO `Album`(`Album_ID`, `Album_Name`, `Album_Genre`, `Artist_ID`) VALUES ({},'{}','{}',{})".format(new_id, album, genre, artist_id)
    albums.append(insert)
    albums_to_add.append("album_ids['" + album + "'] = " + str(new_id))
    album_ids[album] = new_id
    return new_id

scope = 'user-library-read'

if len(sys.argv) > 1:
    username = sys.argv[1]
else:
    print("Usage: %s username" % (sys.argv[0]))
    sys.exit()

token = util.prompt_for_user_token(username, scope)

artist_ids = {}
album_ids = {}
init_artist_ids()
init_album_ids()

songs = []
users = []
artists = []
albums = []

if token:
    sp = spotipy.Spotify(auth=token)
    results = sp.current_user_saved_tracks(limit=50)
    for item in results['items']:
        track = item['track']
        track_id = track['id']

        analysis = sp.audio_analysis(track_id)
        features = sp.audio_features(tracks=[track_id])

        time = item['added_at']
        date = time[0 : time.find('T')]
        hour = time[time.find('T') + 1 : time.find('Z') - 3].replace(":", "")
        name = track['name']
        artist = track['artists'][0]['name']
        album = track['album']['name']

        tempo = analysis['track']['tempo']
        danceability = features[0]['danceability']
        acousticness = features[0]['acousticness']
        energy = features[0]['energy']
        valence = features[0]['valence']

        genres = sp.artist(track['artists'][0]['id'])['genres']
        genre = genres[0] if (len(genres) > 0) else 'Pop'

        artist_id = get_artist_id(artist, track['artists'][0]['id'])
        album_id = get_album_id(album, track['album']['id'], artist, track['artists'][0]['id'])

        insert = "INSERT INTO `Song`(`Song_ID`, `Song_Name`, `Song_Tempo`, `Song_Danceability`, `Song_Acoustics`, `Song_Energy`, `Song_Valence`, `Artist_ID`, `Album_ID`, `Song_Genre`) VALUES ('{}', '{}',{},{},{},{},{},{},{},'{}')".format(track_id, name, tempo, danceability, acousticness, energy, valence, artist_id, album_id, genre)
        songs.append(insert)
        insert2 = "INSERT INTO `User`(`User_ID`, `Song_ID`, `Time`, `Date`) VALUES ('{}','{}',{},'{}')".format(sys.argv[1], track_id, hour, date)
        users.append(insert2)
else:
    print("Can't get token for", username)

f = open("songs.txt", "w")
for song in songs:
    f.write(song + ";")
    f.write("\n")
f.close()

f = open("user.txt", "w")
for user in users:
    f.write(user + ";")
    f.write("\n")
f.close()

f = open("albums.txt", "w")
for album in albums:
    f.write(album + ";")
    f.write("\n")
f.close()

f = open("artists.txt", "w")
for artist in artists:
    f.write(artist + ";")
    f.write("\n")
f.close()

f = open("artist_to_add.txt", "w")
for artist in artists_to_add:
    f.write(artist)
    f.write("\n")
f.close()

f = open("albums_to_add.txt", "w")
for album in albums_to_add:
    f.write(album)
    f.write("\n")
f.close()