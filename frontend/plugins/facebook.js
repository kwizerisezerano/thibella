export default defineNuxtPlugin(() => {
  if (typeof window !== "undefined") {
    window.fbAsyncInit = function () {
      FB.init({
        appId: '585108821088387', // Replace with your actual Facebook App ID
        cookie: true,
        xfbml: true,
        version: 'v19.0',
      });
    };

    (function (d, s, id) {
      let js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js';
      fjs.parentNode.insertBefore(js, fjs);
    })(document, 'script', 'facebook-jssdk');
  }
});
