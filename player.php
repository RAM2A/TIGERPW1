<?php
header('Access-Control-Allow-Origin: *');


?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8" />
  <title>PW PLAYER</title>
  <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
  <link href="https://unpkg.com/@videojs/themes@1/dist/sea/index.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons@2.2.1/dist/videojs-seek-buttons.css">

<style>
  #test {
  width: 480px;
  margin: 0 auto;
}
.video-js .vjs-menu-button-inline.vjs-slider-active,
.video-js .vjs-menu-button-inline:focus,
.video-js .vjs-menu-button-inline:hover,
.video-js.vjs-no-flex .vjs-menu-button-inline {
    width: 10em
}

.video-js .vjs-controls-disabled .vjs-big-play-button {
    display: none!important
}

.video-js .vjs-control {
    width: 3em
}

.video-js .vjs-menu-button-inline:before {
    width: 1.5em
}

.vjs-menu-button-inline .vjs-menu {
    left: 3em
}

.video-js.vjs-paused .vjs-big-play-button,
.vjs-paused.vjs-has-started.video-js .vjs-big-play-button {
    display: block
}

.video-js .vjs-load-progress div,
.vjs-seeking .vjs-big-play-button,
.vjs-waiting .vjs-big-play-button {
    display: none!important
}

.video-js .vjs-mouse-display:after,
.video-js .vjs-play-progress:after {
    padding: 0 .4em .3em
}

.video-js.vjs-ended .vjs-loading-spinner {
    display: none
}

.video-js.vjs-ended .vjs-big-play-button {
    display: block!important
}

.video-js *,
.video-js:after,
.video-js:before {
    box-sizing: inherit;
    font-size: inherit;
    color: inherit;
    line-height: inherit
}

.video-js.vjs-fullscreen,
.video-js.vjs-fullscreen .vjs-tech {
    width: 100%!important;
    height: 100%!important
}

.video-js {
    font-size: 14px;
    overflow: hidden
}

.video-js .vjs-control {
    color: inherit
}

.video-js .vjs-menu-button-inline:hover,
.video-js.vjs-no-flex .vjs-menu-button-inline {
    width: 8.35em
}

.video-js .vjs-volume-menu-button.vjs-volume-menu-button-horizontal:hover .vjs-menu .vjs-menu-content {
    height: 3em;
    width: 6.35em
}

.video-js .vjs-control:focus:before,
.video-js .vjs-control:hover:before {
    text-shadow: 0 0 1em #fff, 0 0 1em #fff, 0 0 1em #fff
}

.video-js .vjs-spacer,
.video-js .vjs-time-control {
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-flex: 1 1 auto;
    -moz-box-flex: 1 1 auto;
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto
}

.video-js .vjs-time-control {
    -webkit-box-flex: 0 1 auto;
    -moz-box-flex: 0 1 auto;
    -webkit-flex: 0 1 auto;
    -ms-flex: 0 1 auto;
    flex: 0 1 auto;
    width: auto
}

.video-js .vjs-time-control.vjs-time-divider {
    width: 14px
}

.video-js .vjs-time-control.vjs-time-divider div {
    width: 100%;
    text-align: center
}

.video-js .vjs-time-control.vjs-current-time {
    margin-left: 1em
}

.video-js .vjs-time-control .vjs-current-time-display,
.video-js .vjs-time-control .vjs-duration-display {
    width: 100%
}

.video-js .vjs-time-control .vjs-current-time-display {
    text-align: right
}

.video-js .vjs-time-control .vjs-duration-display {
    text-align: left
}

.video-js .vjs-play-progress:before,
.video-js .vjs-progress-control .vjs-play-progress:before,
.video-js .vjs-remaining-time,
.video-js .vjs-volume-level:after,
.video-js .vjs-volume-level:before,
.video-js.vjs-live .vjs-time-control.vjs-current-time,
.video-js.vjs-live .vjs-time-control.vjs-duration,
.video-js.vjs-live .vjs-time-control.vjs-time-divider,
.video-js.vjs-no-flex .vjs-time-control.vjs-remaining-time {
    display: none
}

.video-js.vjs-no-flex .vjs-time-control {
    display: table-cell;
    width: 4em
}

.video-js .vjs-progress-control {
    position: absolute;
    left: 0;
    right: 0;
    width: 100%;
    height: .5em;
    top: -.5em
}

.video-js .vjs-progress-control .vjs-load-progress,
.video-js .vjs-progress-control .vjs-play-progress,
.video-js .vjs-progress-control .vjs-progress-holder {
    height: 100%
}

.video-js .vjs-progress-control .vjs-progress-holder {
    margin: 0
}

.video-js .vjs-progress-control:hover {
    height: 1.5em;
    top: -1.5em
}

.video-js .vjs-control-bar {
    -webkit-transition: -webkit-transform .1s ease 0s;
    -moz-transition: -moz-transform .1s ease 0s;
    -ms-transition: -ms-transform .1s ease 0s;
    -o-transition: -o-transform .1s ease 0s;
    transition: transform .1s ease 0s
}

.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active .vjs-control-bar,
.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive .vjs-control-bar,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active .vjs-control-bar,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-control-bar,
.video-js.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-control-bar {
    visibility: visible;
    opacity: 1;
    -webkit-backface-visibility: hidden;
    -webkit-transform: translateY(3em);
    -moz-transform: translateY(3em);
    -ms-transform: translateY(3em);
    -o-transform: translateY(3em);
    transform: translateY(3em);
    -webkit-transition: -webkit-transform 1s ease 0s;
    -moz-transition: -moz-transform 1s ease 0s;
    -ms-transition: -ms-transform 1s ease 0s;
    -o-transition: -o-transform 1s ease 0s;
    transition: transform 1s ease 0s
}

.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-progress-control,
.video-js.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-progress-control {
    height: .25em;
    top: -.25em;
    pointer-events: none;
    -webkit-transition: height 1s, top 1s;
    -moz-transition: height 1s, top 1s;
    -ms-transition: height 1s, top 1s;
    -o-transition: height 1s, top 1s;
    transition: height 1s, top 1s
}

.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active.vjs-fullscreen .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive.vjs-fullscreen .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active.vjs-fullscreen .vjs-progress-control,
.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive.vjs-fullscreen .vjs-progress-control,
.video-js.vjs-has-started.vjs-playing.vjs-user-inactive.vjs-fullscreen .vjs-progress-control {
    opacity: 0;
    -webkit-transition: opacity 1s ease 1s;
    -moz-transition: opacity 1s ease 1s;
    -ms-transition: opacity 1s ease 1s;
    -o-transition: opacity 1s ease 1s;
    transition: opacity 1s ease 1s
}

.video-js.vjs-live .vjs-live-control {
    margin-left: 1em
}

.video-js .vjs-big-play-button {
    top: 50%;
    left: 50%;
    margin-left: -1em;
    width: 2em;
    border: none;
    color: #fff;
    -webkit-transition: border-color .4s, outline .4s, background-color .4s;
    -moz-transition: border-color .4s, outline .4s, background-color .4s;
    -ms-transition: border-color .4s, outline .4s, background-color .4s;
    -o-transition: border-color .4s, outline .4s, background-color .4s;
    transition: border-color .4s, outline .4s, background-color .4s;
    background-color: rgba(0, 0, 0, .45);
    font-size: 3.5em;
    border-radius: 50%;
    height: 2em!important;
    line-height: 2em!important;
    margin-top: -1em!important
}

.video-js .vjs-menu-button-popup .vjs-menu {
    left: -3em
}

.video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-content {
    background-color: transparent;
    width: 12em;
    left: -1.5em;
    padding-bottom: .5em
}

.video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item,
.video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-title {
    background-color: #151b17;
    margin: .3em 0;
    padding: .5em;
    border-radius: .3em
}

.video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item.vjs-selected {
    background-color: #2483d5
}

.video-js .vjs-big-play-button:active,
.video-js .vjs-big-play-button:focus,
.video-js:hover .vjs-big-play-button {
    background-color: rgba(36, 131, 213, .9)
}

.video-js .vjs-loading-spinner {
    border-color: rgba(36, 131, 213, .8)
}

.video-js .vjs-control-bar2 {
    background-color: #000
}

.video-js .vjs-control-bar {
    background-color: rgba(0, 0, 0, .3)!important;
    color: #fff;
    font-size: 14px
}

.video-js .vjs-play-progress,
.video-js .vjs-volume-level {
    background-color: #2483d5
}
</style>
</head>

<body>
  <video id="videojs-contrib-eme-player" style="width: 100%; height: 600px" class="video-js vjs-default-skin" controls>
    <!-- <source src="https://penpencil.pc.cdn.bitgravity.com/c25250fc-d702-4f47-8199-d1efbecabe51/master.mpd" type="application/dash+xml" /> -->
    <source src="<?php echo $_GET["url"] ?>"
      type="application/dash+xml" />
  </video>
  <ul></ul>
  <script src="https://vjs.zencdn.net/7.6.6/video.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-eme@4.0.1/dist/videojs-contrib-eme.js"></script>
  <script src="./pw.js"></script>


<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons@2.2.1/dist/videojs-seek-buttons.min.js"></script>
  <script>
    // https://d1d34p8vz63oiq.cloudfront.net/2b8feb5a-39ba-4de5-bf84-6d3feb1f18be/master.mpd TODO

    (function (window, videojs) {
      // TOKEN = "6c568b656920a4ffff4fb8185873c499f50e300f53f8b82bfefd6adb061cf43c";
      // KEY = "9f8cdd9acf834a98aa6f902adc020522";
      // let player = (window.player = videojs("videojs-contrib-eme-player", {
      //   plugins: {
      //     eme: {
      //       keySystems: {
      //         "org.w3.clearkey": {
      //           videoContentType: 'video/mp4;codecs="avc1.42c01e"',
      //           audioContentType: 'audio/mp4;codecs="mp4a.40.2"',
      //           getLicense: (emeOptions, keyMessage, callback) => {
      //             // console.log('emeOptions: ', emeOptions);
      //             // console.log('keyMessage: ', keyMessage);
      //             // Parse the clearkey license request.
      //             let request = JSON.parse(
      //               new TextDecoder().decode(keyMessage)
      //             );

      //             // console.log('request', request);
      //             // console.log('key_id:', this.base64ToHex(request.kids[0]));
      //             let keyObj = {
      //               kty: "oct",
      //               kid: request.kids[0],
      //               k: hexToBase64(KEY) // This key sould be come from server
      //             };

      //             // console.log('keys', JSON.stringify(keyObj), this.base64ToHex(request.kids[0]), this.KEY);
      //             callback(
      //               null,
      //               new TextEncoder().encode(
      //                 JSON.stringify({
      //                   keys: [keyObj]
      //                 })
      //               )
      //             );
      //           }
      //         }
      //       }
      //     }
      //   }
      // }));

      TOKEN = "<?php echo file_get_contents("token.txt"); ?>";
      let player = (window.player = videojs("videojs-contrib-eme-player", {
       autoplay: true,
        playbackRates: [0.7, 1.0, 1.5, 2.0,2.5,3],
        plugins: {
          eme: {
            keySystems: {
              "org.w3.clearkey": {
                videoContentType: 'video/mp4;codecs="avc1.42c01e"',
                audioContentType: 'audio/mp4;codecs="mp4a.40.2"',
                getLicense: (emeOptions, keyMessage, callback) => {
                  console.log('emeOptions: ', emeOptions);

                  let request = JSON.parse(
                    new TextDecoder().decode(keyMessage)
                  );

                  console.log('request', request);


                  const key = encrypt(
                    TOKEN,
                    base64ToHex(request.kids[0])
                  );

                  const t = makeRequest("GET", "/auth.php?key=" + key).then((res) => {


                    console.log(res.responseText,"res");


                    let keyObj = {
                    kty: "oct",
                    kid: request.kids[0],
                    k: hexToBase64(
                      decrypt(
                        TOKEN,
                        res.responseText
                      )
                    ) // This key sould be come from server
                  };

                  console.log('keys', JSON.stringify(keyObj), this.base64ToHex(request.kids[0]), this.KEY);

                  callback(
                    null,
                    new TextEncoder().encode(
                      JSON.stringify({
                        keys: [keyObj]
                      })
                    )
                  );

                          const playerb = new Plyr('#videojs-contrib-eme-player');

                  });




                }
              }
            }
          }
        }
      }));


player.seekButtons({
    forward: 10,
    back: 10
  });

    })(window, window.videojs);




      // this.globalService.accessToken ->  Bearer . Token

      // inside                 getLicense: (emeOptions, keyMessage, callback) => {
      //                                              |   |  |
      //                     getLicenseFromServer(e, t, i) {
      //                         return Object(r.a)(this, void 0, void 0, (function* () {
      //                             const e = JSON.parse((new TextDecoder).decode(t)),
      //                                 r = {
      //                                     key: this.videoLicenseService.encrypt(this.globalService.accessToken, this.videoLicenseService.base64ToHex(e.kids[0]))
      //                                 };
      //                             try {

      // const t = yield this.videoLicenseService.getKeyFromServer(r).toPromise(), n = {
      //                                                                        |
      // https://api.penpencil.xyz/v1/videos/get-otp?key=UgANUw8HDwMFCQZVVwMFXlZWBVNRClQPDAgBAAFRCAo= (WITH ACCESS TOKEN)

      //                                     kty: "oct",
      //                                     kid: e.kids[0],
      //                                     k: this.videoLicenseService.hexToBase64(this.videoLicenseService.decrypt(this.globalService.accessToken, t.data.otp))
      //                                 };
      //                                 i(null, (new TextEncoder).encode(JSON.stringify({
      //                                     keys: [n]
      //                                 })))
      //                             } catch (n) {
      //                                 yield this.navContrl.pop()
      //                             }
      //                         }))
      //                     }
  </script>
</body>
    <script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>


</html>