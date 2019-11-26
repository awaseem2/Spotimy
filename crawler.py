import sys
import spotipy
import spotipy.util as util

#change later
#https://spotipy.readthedocs.io/en/latest/
#$env:SPOTIPY_REDIRECT_URI="https://www.spotify.com/us/"
#$env:SPOTIPY_CLIENT_SECRET="5a312dc3c53a4249a46a557accc22ac9"
#$env:SPOTIPY_CLIENT_ID="4f657b938eed4221b0a27491a8291ff4"
'''
util.prompt_for_user_token('aly5321', 'user-follow-read', 
    client_id = '4f657b938eed4221b0a27491a8291ff4',
    client_secret = '5a312dc3c53a4249a46a557accc22ac9',
    redirect_uri = 'https://www.spotify.com/us/')
'''

arists = []
albums = []
artists_to_add = []

def init_artist_ids():
    artist_ids['5 Seconds of Summer'] = 1
    artist_ids['Fall Out Boy'] = 2
    artist_ids['Lizzo'] = 3
    artist_ids['Kendrick Lamar'] = 4
    artist_ids['Louis Tomlinson'] = 5
    artist_ids['Harry Styles'] = 6
    artist_ids['Niall Horan'] = 7
    artist_ids['Zayn Malik'] = 8

def init_album_ids():
    album_ids['5 Seconds of Summer'] = 1
    album_ids['Teeth'] = 2
    album_ids['American Beauty/American Psycho'] = 3
    album_ids['Cuz I Love You'] = 4
    album_ids['Folie a Deux'] = 5
    album_ids['DAMN'] = 6

def get_artist_id(artist):
    if artist in artist_ids:
        return artist_ids[artist]
    new_id = len(artist_ids) + 1
    artist_ids[artist] = new_id

    #insert = "INSERT INTO `Artist`(`Artist_ID`, `Artist_Name`, `Artist_Popularity`, `Artist_Genre`) VALUES ({},'{}',{},'{}')".format(new_id)
    #artists_to_add.append("artist_ids['" + artist_name + "'] = " + str(new_id))
    return new_id

def get_album_id(album):
    if album in album_ids:
        return album_ids[album]
    new_id = len(album_ids) + 1
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
user_info = []

if token:
    sp = spotipy.Spotify(auth=token)
    results = sp.current_user_saved_tracks(limit=20)
    for item in results['items']:
        track = item['track']
        track_id = track['id']

        analysis = sp.audio_analysis(track_id)
        features = sp.audio_features(tracks=[track_id])

        time = item['added_at']
        date = time[0 : time.find('T')]
        hour = time[time.find('T') + 1 : time.find('Z') - 3].replace(":", "")
        print(hour)
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

        artist_id = get_artist_id(artist)
        album_id = get_album_id(album)

        insert = "INSERT INTO `Song`(`Song_ID`, `Song_Name`, `Song_Tempo`, `Song_Danceability`, `Song_Acoustics`, `Song_Energy`, `Song_Valence`, `Artist_ID`, `Album_ID`, `Song_Genre`) VALUES ('{}', '{}',{},{},{},{},{},{},{},'{}')".format(track_id, name, tempo, danceability, acousticness, energy, valence, artist_id, album_id, genre)
        songs.append(insert)
        #print(insert)
        insert2 = "INSERT INTO `User`(`User_ID`, `Song_ID`, `Time`, `Date`) VALUES ('{}','{}',{},{})".format(sys.argv[1], track_id, hour, date)
        user_info.append(insert2)
        break
else:
    print("Can't get token for", username)

