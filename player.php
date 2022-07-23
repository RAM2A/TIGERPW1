<?php
header('Access-Control-Allow-Origin: *');


?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8" />
  <title>PW PLAYER</title>
  
  
<style>

  div#video_player_mpeg {
    width: 100%;
    height:35rem;
}
</style>
  
<link href="/new-player/css/default.css" rel="stylesheet">
<link href="/new-player/css/plugins/pip.css" rel="stylesheet">

<link rel='stylesheet' id='materialicons-css' href='https://fonts.googleapis.com/icon?family=Material+Icons' type='text/css' media='all' />


  <script src="/new-player/js/jquery.min.js"></script>
  <script src="/new-player/js/video.min.js"></script>
<script src="/new-player/js/http-source-selector.min.js"></script>
<script src="/new-player/js/quality-levels.min.js"></script>
<script src="/new-player/js/social.js"></script>
<script src="/new-player/js/share.js"></script>
<script src="/new-player/js/seek-buttons.js"></script>
<script src="/new-player/js/download.js"></script>
<script src="/new-player/js/watermark.js"></script>
<script src="/new-player/js/volume.js"></script>
<script src="/new-player/js/toggle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-resolution-switcher/0.4.2/videojs-resolution-switcher.min.js" >

    
  </script>
</head>

<body>
<video id="video_player_mpeg" class="video-js vjs-default-skin vjs-big-play-centered" controls="" preload="auto" poster="https://physicswallah.pages.dev/uploads/physicswallah.png">

    <!-- <source src="https://penpencil.pc.cdn.bitgravity.com/c25250fc-d702-4f47-8199-d1efbecabe51/master.mpd" type="application/dash+xml" /> -->
    <source src="<?php echo $_GET["url"] ?>"
      type="application/dash+xml" />
  </video>
  <ul></ul>

</body>
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
      let player = (window.player = videojs("video_player_mpeg", {
       autoplay: true,
        playbackRates: [0.7, 1.0, 1.5, 2.0,2.5,3],
        plugins: {
                videoJsResolutionSwitcher: {
                  default: 'high',
                  dynamicLabel: true
                },
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

</html>