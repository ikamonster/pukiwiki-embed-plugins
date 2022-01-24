# PukiWiki外部サービス埋め込みプラグイン

各種ウェブサービスのHTMLウィジェットを埋め込むためのPukiWiki用プラグインの使用法一覧です。

**凡例**

プラグインの引数は下記の書式で表現しています。
- [] … 省略でき必要に応じて記述します
- | … |で区切られた項目のうち１つを記述します
- {} … 中カッコ内の引数は任意の順序で記述できます

## 動画・画像

### YouTube

YouTube動画再生プレイヤーを表示する。


```
youtube(id[,[width][,[loop][,[start][,autoplay]]]])
```

- id       … 動画ID。YouTubeサイトの動画ページURL「``//www.youtube.com/watch?v=XXXXXXXXXXX``」の「XXXXXXXXXXX」部分
- width    … 動画の幅（px）。省略時の既定値は 640
- loop     … 1：ループ再生、0：通常再生。省略時の既定値は 0
- start    … 再生開始位置（秒）。省略時の既定値は 0
- autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0。モバイル環境では効かないことがある

<br>

### Vimeo

Vimeo動画再生プレイヤーを表示する。


```
vimeo(id[,[width][,[loop][,autoplay]]])
```

- id       … 動画ID。Vimeoサイトの動画ページURL「``//www.vimeo.com/watch?v=XXXXXXXXXXX``」の「XXXXXXXXXXX」部分
- width    … 動画の幅（px）。省略時の既定値は 640
- loop     … 1：ループ再生、0：通常再生。省略時の既定値は 0
- autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0。モバイル環境では効かないことがある

<br>

### ニコニコ動画

ニコニコ動画再生プレイヤーを表示する。


```
nicodou(id[,[width][,start]])
```

- id       … 動画ID。ニコニコ動画サイトの動画ページURL「``//www.nicovideo.jp/watch/smXXXXX``」の「smXXXXX」部分
- width    … 動画の幅（px）。省略時の既定値は 640
- start    … 再生開始位置（秒）。省略時の既定値は 0

<br>

### Twitch

Twitchチャンネル・動画・チャットを埋め込む。


```
twitch(channel|chat|video,id[,width])
```

- 第1引数 … 埋め込みウィジェットの種類。chennnel：チャンネル, chat：チャット, video：ビデオ
- id      … チャンネルやビデオのID。Twitch内対象コンテンツURL「``//player.twitch.tv/?channel=XXXXXXXXX``」「``//player.twitch.tv/?autoplay=false&video=XXXXXXXXX``」における「XXXXXXXXX」部分
- width   … ウィジェットの幅（px）。省略すると標準の幅となる

<br>

### Instagram

Instagram埋め込みウィジェットを表示する。


```
instagram(userName,videoID)
```

- userName … 「@」から始まるユーザー名
- videoID  … ビデオID。Instagramサイト発行の埋め込みコード内「data-video-id="XXXXXXXXXXXXXXXXXXX"」の「XXXXXXXXXXXXXXXXXXX」部分

<br>

### SnapChatストーリー

SnapChatストーリーを埋め込む。


```
snapchat(id)
```

- id … ユーザー名またはスナップID。SnapChatサイト発行の埋め込みコード内「``//play.snapchat.com/UserName``」の「UserName」部分、または「``//play.snapchat.com/s:XXXXXXXXXXXXXXXXXXXXXX``」の「s:XXXXXXXXXXXXXXXXXXXXXX」部分。「?」以降は含まないので注意

<br>

### TikTok

TikTok動画を埋め込む。

※ 2020年4月現在、TikTok埋め込みウィジェットは Internet Explorer および Edge 旧版（EdgeHTML版）では正常に表示されません。


```
tiktok(userName,videoID)
```

- userName … 「@」から始まるユーザー名
- videoID … 動画ID。TikTokサイト発行の埋め込みコード内「data-video-id="XXXXXXXXXXXXXXXXXXX"」の「XXXXXXXXXXXXXXXXXXX」部分

<br>

### imgur

imgur画像／動画を埋め込む。


```
imgur(id)
```

- id … 画像／動画ID。imgurサイト発行の埋め込みコード内「data-id="a/XXXXXX"」の「XXXXXX」部分

<br>

### GIPHY

GIPHY画像を埋め込む。


```
giphy(id,width,height)
```

- id     … 画像ID。GIPHYサイト発行の埋め込みコード内「``//giphy.com/embed/XXXXXXXXXXXXXXXXXX``」の「XXXXXXXXXXXXXXXXXX」部分
- width  … 画像の幅（px）。GIPHYサイト発行の埋め込みコード内「width="XXX"」の「XXX」部分
- height … 画像の高さ（px）。GIPHYサイト発行の埋め込みコード内「height="XXX"」の「XXX」部分

<br>

### tenor

tenor画像を埋め込む。


```
tenor(id,aspect,width)
```

- id     … 画像ID。tenorサイト発行の埋め込みコード内「data-postid="XXXXXXXX"」の「XXXXXXXX」部分
- aspect … 画像の縦横比。tenorサイト発行の埋め込みコード内「data-aspect-ratio="XXX"」の「XXX」部分。省略時の既定値は1.0
- width  … 画像の幅（px）。省略時の既定値は640

**音楽・音声

### Apple Music

Apple Music再生プレイヤーを表示する。アルバム再生・曲再生のみ可能、アーティスト情報やプレイリスト等には非対応。


```
applemusic(albumID[,[songID][,country]])
```

- albumID … アルバムID。Apple Musicサイト発行の埋め込みコード内「``//embed.music.apple.com/ZZ/album/XXXXXXXXXX?app=music``」の「XXXXXXXXXX」部分
- songID  … 曲ID。指定すると曲再生ウィジェット、省略するとアルバム再生ウィジェットとなる。Apple Musicサイト発行の埋め込みコード内「``//embed.music.apple.com/ZZ/album/XXXXXXXXXX?i=YYYYYYYYYY&app=music``」の「YYYYYYYYYY」部分
- country … 2文字国名コード。Apple Musicサイト発行の埋め込みコード内「``//embed.music.apple.com/ZZ/album/XXXXXXXXXX?i=YYYYYYYYYY&app=music``」の「ZZ」部分。省略時の既定値は jp

<br>

### Spotify

Spotify再生プレイヤーを表示する。


```
spotify(type,id)
```

- type … 再生種別。artist, album, track, playlist, podcast, episode のいずれか。Spotifyサイト発行の埋め込みコード内「``//open.spotify.com/embed/?????/XXXXXXXXXXXXXXXXXXXXXX``」の「?????」部分
- id   … コンテンツID。Spotifyサイト発行の埋め込みコード内「``//open.spotify.com/embed/?????/XXXXXXXXXXXXXXXXXXXXXX``」の「XXXXXXXXXXXXXXXXXXXXXX」部分

<br>

### Bandcamp

Bandcamp再生プレイヤーを表示する。


```
bandcamp(albumID[,[type][,theme]])
```

- albumID … アルバムID。Bandcampサイト発行の埋め込みコード内「/album=XXXXXXXXXX/」の「XXXXXXXXXX」部分
- type    … 表示種別。standard, slim, artwork のいずれか。省略時の既定値は standard
- theme   … dark：暗い色調で表示。省略すると明るい色調で表示

<br>

### SoundCloud

SoundCloud再生プレイヤーを表示する。


```
soundcloud(track|playlist,trackID[,[comment][,[color][,[width][,visual]]]])
```

- 第1引数 … track：曲再生、playlist：プレイリスト／アルバム再生
- id      … 曲／プレイリスト／アルバムID。SoundCloudサイト発行の埋め込みコード内URL「``//api.soundcloud.com/tracks/XXXXXXXXX&color=...``」または「``//api.soundcloud.com/playlists/XXXXXXXXX&color=...``」における「XXXXXXXXX」部分
- comment … 1：コメント表示、0：コメント非表示。省略時の既定値は 0。再生モードによっては無視される
- color   … 再生ボタンの色を表す #RRGGBB 形式のカラーコード文字列。省略時の既定値はブランドカラー
- width   … プレイヤーの幅（px）。省略すると領域いっぱいに表示
- visual  … 1：視覚強調表示、0：通常表示。省略時の既定値は 0

<br>

### Megaphone

Megaphone再生プレイヤーを表示する。


```
megaphone(id[,theme])
```

- id       … 動画ID。Megaphoneサイトの動画ページURL「cms.megaphone.fm/channel/vergecast?selected=XXXXXXXXXXXXX」の「XXXXXXXXXXXXX」部分
- theme    … dark:ダークモード。省略時の既定値はライトモード

<br>

### omny.fm

omny.fm再生プレイヤーを表示する。


```
omnyfm(id[,type])
```

- id   … 音声ID。omny.fmサイトの音声ページURL「``//omny.fm/shows/XXXX/YYYY``」の「XXXX/YYYY」部分
- type … 表示種別。wide, simple, square のいずれか。省略時の既定値は wide

<br>

### Voicy

Voicy再生プレイヤーを表示する。


```
voicy(channelID,showID[,width])
```

- channelID … チャンネルID。Voicyサイト発行の埋め込みコード内「``//voicy.jp/embed/channel/XXXX/YYYYY``」の「XXXX」部分
- showID    … 番組ID。Voicyサイト発行の埋め込みコード内「``//voicy.jp/embed/channel/XXXX/YYYYY``」の「YYYYY」部分
- width     … プレイヤーの幅（px）。省略すると領域いっぱいに表示

**3DCG・VR

### Sketchfab

Sketchfabウィジェットを埋め込む。


```
sketchfab(id[,[width][,[height][,[autostart][,[aniEntrance][,[turn][,preload]]]]]])
```

- id … モデルID。Sketchfabサイト発行の埋め込みコード内「``//sketchfab.com/models/XXXXXXXXXX/embed``」の「XXXXXXXXXX」部分
- width … ウィジェットの幅（px）。省略時の既定値は 640
- height … ウィジェットの高さ（px）。省略時の既定値は 480
- autostart … 1：自動再生、0：手動再生。省略時の既定値は 0
- aniEntrance … 1：カメラ移動しながら開始、0：静止したまま開始。省略時の既定値は 0
- turn … 1：カメラ自動旋回、0：カメラ静止。省略時の既定値は 0
- preload … 1：データの事前ロードあり、0：事前ロードなし。省略時の既定値は 0

<br>

### STYLY

STYLYウィジェットを埋め込む。


```
styly(id[,width])
```

- id       … コンテンツID。STYLYサイトのコンテンツページURL「``//gallery.styly.cc/embed?g=XXXXXXXXXXX``」の「XXXXXXXXXXX」部分
- width    … ウィジェットの幅（px）。省略時の既定値は 640

**SNS

### Twitter

Twitterウィジェットを埋め込む。


```
twitter(type,user[,[id][,[width][,[height][,theme]]]])
```

- type   … 表示種別。tweet（単一のツイート）, profile（userのツイート）, likes（userがいいねしたツイート）, list（userの作成リスト）, collection（userのまとめたツイート） のいずれか
- user   … 「@」から始まるユーザー名
- id     … ツイート／リスト／コレクションID。ツイッターURL「``//twitter.com/yyyy/status/XXXXXXX``」または「``//twitter.com/yyyy/timeline/XXXXXXX``」の「XXXXXXX」部分。不要な type では省略
- width  … ウィジェットの幅（px）。省略時の既定値は 500
- height … ウィジェットの高さ（px）。省略時の既定値は 500。0 で高さ無制限
- theme  … dark：暗い色調で表示。省略すると明るい色調で表示

**記事

### ウェブサイト全般

ブログカードを表示する。


```
blogcard(url)
```

- url … リンク先ページのURL

※サムネイル画像を生成するため、PHPにGDモジュールが必要です。なくても動作しますが、重くなるため推奨しません。~
※リンク先ページの情報はデフォルトで1週間キャッシュされます。キャッシュを消去するには次のコマンドを実行してください。

 （ウィキのURL）?plugin=blogcard&query=clear

<br>

### note

noteウィジェットを埋め込む。


```
note(id)
```

- id … 記事ID。noteサイト発行の埋め込みコード内「``//note.com/embed/notes/XXXXXXXXXXXXX``」の「XXXXXXXXXXXXX」部分

**スライド

### SlideShare

SlideShareウィジェットを埋め込む。


```
slideshare(id[,[startSlide][,width]])
```

- id         … スライドID。SlideShareサイト発行の埋め込みコード内「``//www.slideshare.net/slideshow/embed_code/key/XXXXXXXXXXXXXX``」の「XXXXXXXXXXXXXX」部分
- startSlide … スライドの表示開始ページ。1～ページ数まで。省略時の既定値は 1
- width      … ウィジェットの幅（px）。省略時の既定値は 595

<br>

### Speaker Deck

Speaker Deckのスライドを埋め込む。


```
speakerdeck(id[,[width][,[start][,ratio]]])
```

- id    … スライドID。Speaker Deckサイト発行の埋め込みコード内「data-id="XXXXX"」の「XXXXX」部分
- width … スライドの幅（px）。省略時の既定値は 640
- start … スライドの開始ページ（1～）。省略時の既定値は 1
- ratio … スライドの縦横比。SpeakerDeckサイト発行の埋め込みコード内「data-ratio="X.XXX"」の「X.XXX」部分。省略時の既定値は 1.77777777777778

<br>

### Googleスライド

Googleスライドを埋め込む。


```
googleslides(id[,[width][,[delay][,[autoStart][,loop]]]])
```

- id        … スライドID。Googleスライドサイト発行のウェブ公開用埋め込みコード内「``//docs.google.com/presentation/d/e/XXXXXXXXXX/embed``」の「XXXXXXXXXX」部分
- width     … スライドの幅（px）。省略時の既定値は 480
- delay     … スライドショーのページ送り間隔（ミリ秒）。省略時の既定値は 3000
- autoStart … 1：プレイヤーの読み込み後すぐにスライドショーを開始する。省略時の既定値は 0（オフ）
- loop      … 1：最後のスライドまで到達したらスライドショーを再度開始する省略時の既定値は 0（オフ）

**地図

### Googleマイマップ

Googleマイマップを埋め込む。


```
googlemymaps(id[,[width][,height]])
```

- id     … 地図ID。Googleマイマップサイト発行の埋め込みコード内「``//googlemymaps.com/embed/googlemymaps/XXXXXXXXXXXXX``」の「XXXXXXXXXXXXX」部分
- width  … 地図の幅（px）。省略時の既定値は 640
- height … 地図の高さ（px）。省略時の既定値は 480

<br>

### いつもNAVI

いつもNAVI地図を埋め込む。


```
itsmonavi(lat,lon[,[level][,[width][,height]]])
```

- lat … 緯度。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「XXXXXXXXXXXXX」部分
- lon … 経度。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「YYYYYYYYY」部分
- level … 表示倍率（1～18）。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「ZZ」部分。省略時の既定値は 10
- width … 地図の幅（px）。省略時の既定値は 640
- height … 地図の高さ（px）。省略時の既定値は 480

**フォーム

### Googleフォーム

Googleフォームを埋め込む。


```
googleforms(id[,[width][,height]])
```

- id     … 記事ID。Googleフォームサイト発行の埋め込みコード内「``//docs.google.com/forms/d/e/XXXXXXXXXXXXX/viewform``」の「XXXXXXXXXXXXX」部分
- width  … ウィジェットの幅（px）。省略時の既定値は 640
- height … ウィジェットの高さ（px）。省略時の既定値は 382

**カレンダー

### Googleカレンダー

Googleカレンダーを埋め込む。


```
googlecalendar([width][,[height],id[,id2,id3,...]])
```

- width       … カレンダーの幅（px）。省略時の既定値は 800
- height      … カレンダーの高さ（px）。省略時の既定値は 600
- 第3引数以降 … カレンダーID。Googleカレンダーサイト発行の埋め込みコード内「src=XXXXXXXXXXX」の「XXXXXXXXXXX」部分。複数指定可能

**ワープロ・表計算

### Googleスプレッドシート

Googleスプレッドシートを埋め込む。


```
googlesheets(docID[,[sheetID][,height]])
```

- docID   … ドキュメントID。Googleスプレッドシートサイト発行の埋め込みコード内「``//docs.google.com/spreadsheets/d/e/XXXXX/pubhtml``」の「XXXXX」部分
- sheetID … シートID。ドキュメント全体ではなく、特定シートのみ埋め込む場合に指定。Googleスプレッドシートサイト発行の埋め込みコード内「``//docs.google.com/spreadsheets/d/e/XXXXX/pubhtml?gid=YYYYY&...``」の「YYYYY」部分
- height  … ウィジェットの高さ（px）。省略時の既定値は 400

<br>

### Googleドキュメント

Googleドキュメントを埋め込む。


```
googledocs(docID[,height])
```

- docID   … ドキュメントID。Googleドキュメントサイト発行の埋め込みコード内「``//docs.google.com/document/d/e/XXXXX/pub``」の「XXXXX」部分
- height  … ウィジェットの高さ（px）。省略時の既定値は 400

**開発

### GitHub Gist

GitHub Gistを埋め込む。


```
gist(user,id[,height])
```

- user   … ユーザー名。GitHubサイト発行のGist埋め込みコード内「``//gist.github.com/XXXX/YYYYYYYY`」の「XXXX」部分
- id     … GistID。GitHubサイト発行のGist埋め込みコード内「``//gist.github.com/XXXX/YYYYYYYY``」の「YYYYYYYY」部分
- height … ウィジェットの高さ。単位は px, em, % 等（単位なしならpxとみなす）。この引数が指定されると、Gistウィジェットがiframe内に作られる

<br>

### CodePen

CodePenウィジェットを埋め込む。


```
codepen(id[,[user][,[title][,[width][,theme]]]])
```

- id    … コードID。CodePenサイト発行の埋め込みコード内「data-slug-hash="XXXXXXX"」の「XXXXXXX」部分
- user  … ユーザー名。CodePenサイト発行の埋め込みコード内「data-user="XXXXXXX"」の「XXXXXXX」部分
- title … 題名。CodePenサイト発行の埋め込みコード内「data-pen-title="XXXXXXX"」の「XXXXXXX」部分
- width … ウィジェットの幅（px）。省略時の既定値は 806
- theme  … default：通常の色調で表示、light：明るい色調で表示、dark：暗い色調で表示。省略時の既定値は default

<br>

### Glitch

Glitchウィジェットを埋め込む。


```
glitch(id[,[code][,height]])
```

- id     … プロジェクトID。GlitchサイトのプロジェクトページURL「https://glitch.com/~XXXXX」の「XXXXX」部分
- code   … 1：ソースコード表示。省略するとプレビュー表示
- height … ウィジェットの高さ（px）。省略時の既定値は 500

<br>

### Shadertoy

Shadertoyウィジェットを埋め込む。


```
shadertoy(id[,[width][,autoplay]])
```

- id       … 動画ID。Shadertoyサイトの動画ページURL「``//gallery.shadertoy.cc/embed?g=XXXXXXXXXXX``」の「XXXXXXXXXXX」部分
- width    … 動画の幅（px）。省略時の既定値は 560
- autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0

<br>

### Scratch

Scratchを埋め込む。


```
scratch(id[,[width][,height]])
```

- id     … プロジェクトID。SCRATCHサイト発行の埋め込みコード内「``//scratch.mit.edu/projects/XXXXXXXXX/``」の「XXXXXXXXX」部分
- width  … ウィジェットの幅（px）。省略すると標準の幅
- height … ウィジェットの高さ（px）。省略すると標準の高さ

**ショッピング

### Steam

Steamウィジェットを埋め込む。


```
steam(id[,introduction])
```

- id           … Steam内対象ソフトのストアページURL「``//store.steampowered.com/app/XXXXXX/Hoge/``」における「XXXXXX」部分
- introduction … 任意の文字列。省略すると各ソフト既定の紹介文が表示される

<br>

### itch.io

itch.ioウィジェットを埋め込む。


```
itchio(id)
```

- id … ページID。itch.ioサイト発行の埋め込みコード内「``//itch.io/embed/XXXXXX``」の「XXXXXX」部分

**クラウドファンディング・寄付

### Kickstarter

KickStarterウィジェットを埋め込む。


```
kickstarter(creator,project[,[type][,width]])
```

- creator … クリエイター名。KickStarterサイトのプロジェクトページURL「``//www.kickstarter.com/projects/????/XXXX``」の「????」部分
- project … プロジェクト名。KickStarterサイトのプロジェクトページURL「``//www.kickstarter.com/projects/????/XXXX``」の「XXXX」部分
- type    … ウィジェット種別。card：カード表示, video：ビデオ表示。省略時の既定値は card
- width   … ビデオの幅（px）。省略時の既定値は 640

<br>

### CAMPFIRE

CAMPFIREウィジェットを埋め込む。


```
campfire(id)
```

- id … プロジェクトID。CAMPFIREサイトのプロジェクトページURL「``//camp-fire.jp/projects/view/XXXXXX``」の「XXXXXX」部分（?以降は省く）

<br>

### Makuake

Makuakeウィジェットを埋め込む。


```
makuake(project[,type])
```

- project … プロジェクト名。MakuakeサイトのプロジェクトページURL「``//www.makuake.com/project/XXXXX/``」の「XXXXX」部分
- type    … 表示種別。default, length, wide, square, hero のいずれか。省略時の既定値は default

<br>

### GlobalGiving

GlobalGivingウィジェットを埋め込む。


```
globalgiving(id[,height])
```

- id     … プロジェクトID。GlobalGivingサイトのプロジェクトページURL「``//camp-fire.jp/projects/view/XXXXXX``」の「XXXXXX」部分（?以降は省く）
- height … ウィジェットの高さ。単位は px, em, % 等（単位なしならpxとみなす）。この引数が指定されると、GlobalGivingウィジェットがiframe内に作られる
