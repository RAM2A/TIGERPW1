function makeRequest(method, url) {
    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url);
        xhr.onload = function () {
            if (this.status >= 200 && this.status < 300) {
                resolve({
                    status: this.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });
            } else {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.onerror = function () {
            reject({
                status: this.status,
                statusText: xhr.statusText
            });
        };
        xhr.send();
    });
}



var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";


function getAwsKey(e) {
    const t = new r.g()
        .set("Content-Type", "application/json")
        .set("client-type", "WEB");
    return this.httpClient
        .post(this.appUrlService.GET_AWS_KEY(), { url: e }, { headers: t })
        .pipe(Object(n.a)(1), Object(s.a)(o.a));
}


async function getKeyFromServer(e) {
    var data = await makeRequest("GET", "https://pwapi.flixyback.repl.co/auth.php?key=" + e);
    data = JSON.parse(data);
    return data.pipe(Object(n.a)(1), Object(s.a)(o.a));
}




function encrypt(e, t) {
    return (t = xor_encrypt(e, t)), b64_encode(t);
}
function decrypt(e, t) {
    return (t = b64_decode(t)), xor_decrypt(e, t);
}
function b64_encode(e) {
    let t,
        i,
        r,
        n,
        s,
        o,
        a,
        c,
        h,
        l = 0,
        p = "";
    if (!e) return e;
    do {
        (t = e[l++]), (i = e[l++]), (r = e[l++]), (c =
            (t << 16) | (i << 8) | r), (n = (c >> 18) & 63), (s =
                (c >> 12) & 63), (o = (c >> 6) & 63), (a = 63 & c), (p +=
                    b64.charAt(n) +
                    b64.charAt(s) +
                    b64.charAt(o) +
                    b64.charAt(a));
    } while (l < e.length);
    return (h = e.length % 3), (h ? p.slice(0, h - 3) : p) +
        "===".slice(h || 3);
}


function b64_decode(e) {
    let t,
        i,
        r,
        n,
        s,
        o,
        a,
        c,
        h = 0,
        l = [];
    if (!e) return e;
    e += "";
    do {
        (n = b64.indexOf(e.charAt(h++))), (s = b64.indexOf(
            e.charAt(h++)
        )), (o = b64.indexOf(e.charAt(h++))), (a = b64.indexOf(
            e.charAt(h++)
        )), (c = (n << 18) | (s << 12) | (o << 6) | a), (t =
            (c >> 16) & 255), (i = (c >> 8) & 255), (r = 255 & c), l.push(
                t
            ), 64 !== o && (l.push(i), 64 !== a && l.push(r));
    } while (h < e.length);
    return l;
}
function keyCharAt(e, t) {
    return e.charCodeAt(Math.floor(t % e.length));
}
function xor_encrypt(e, t) {
    return Object.assign([], t).map(
        (t, i) => t.charCodeAt(0) ^ keyCharAt(e, i)
    );
}
function xor_decrypt(e, t) {
    return Object.assign([], t)
        .map((t, i) => String.fromCharCode(t ^ keyCharAt(e, i)))
        .join("");
}



// function getLicenseFromServer(e, t, i,token) {
//     return Object(e.t)(this, void 0, void 0, function*() {
//       const e = JSON.parse(new TextDecoder().decode(t)),
//         r = {
//           key: 
//         };

//       try {
//         const t = yield getKeyFromServer(key),
//           n = {
//             kty: "oct",
//             kid: e.kids[0],
//             k: hexToBase64(
//               decrypt(
//                 token,
//                 t.data.otp
//               )
//             )
//           };
//         i(null, new TextEncoder().encode(JSON.stringify({ keys: [n] })));


//       } catch (n) {
//         console.log(n);
//       }
//     });
//   }





// function hexToBase64(str) {
//     return btoa(
//         String.fromCharCode.apply(
//             null,
//             str
//                 .replace(/\r|\n/g, "")
//                 .replace(/([\da-fA-F]{2}) ?/g, "0x$1 ")
//                 .replace(/ +$/, "")
//                 .split(" ")
//         )
//     )
//         .replace(/\+/g, "-")
//         .replace(/\//g, "_")
//         .replace(/=*$/, "");
// }

// function base64ToHex(str) {
//     str = str.replace(/\-/g, "+").replace(/\_/g, "/");
//     for (
//         var i = 0, bin = atob(str.replace(/[ \r\n]+$/, "")), hex = [];
//         i < bin.length;
//         ++i
//     ) {
//         let tmp = bin.charCodeAt(i).toString(16);
//         if (tmp.length === 1) tmp = "0" + tmp;
//         hex[hex.length] = tmp;
//     }
//     return hex.join("");
// }

// function base64ToHexOld(str) {
//     for (
//         var i = 0, bin = atob(str.replace(/[ \r\n]+$/, "")), hex = [];
//         i < bin.length;
//         ++i
//     ) {
//         let tmp = bin.charCodeAt(i).toString(16);
//         if (tmp.length === 1) tmp = "0" + tmp;
//         hex[hex.length] = tmp;
//     }
//     return hex.join("");
// }


function hexToBase64(e) {
    return btoa(
        String.fromCharCode.apply(
            null,
            e
                .replace(/\r|\n/g, "")
                .replace(/([\da-fA-F]{2}) ?/g, "0x$1 ")
                .replace(/ +$/, "")
                .split(" ")
        )
    )
        .replace(/\+/g, "-")
        .replace(/\//g, "_")
        .replace(/=*$/, "");
}

function base64ToHex(e) {
    e = e.replace(/\-/g, "+").replace(/\_/g, "/");
    for (
        var t = 0, i = atob(e.replace(/[ \r\n]+$/, "")), r = [];
        t < i.length;
        ++t
    ) {
        let e = i.charCodeAt(t).toString(16);
        1 === e.length && (e = "0" + e), (r[r.length] = e);
    }
    return r.join("");
}