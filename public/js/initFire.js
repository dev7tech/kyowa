// Initialize Firebase
var config = {
    apiKey: "AIzaSyBp-mvNcNEAMtS_qlOa6ih0jn2W4dkg6pw",
    authDomain: "wandergo-project.firebaseapp.com",
    databaseURL: "https://wandergo-project.firebaseio.com",
    projectId: "wandergo-project",
    storageBucket: "wandergo-project.appspot.com",
    messagingSenderId: "648326883627"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.usePublicVapidKey("BAc-xtNXXvXb-qAifcgbQof5YzUMiLYUkP7mNhZqLQM4Q0RG4dLvGt0IEBtH1JmQUMBjcTDEoGZZd1CJ7LdzrXM");

messaging.requestPermission()
.then(function() {
    console.log('Notification permission granted.');
    return messaging.getToken()
})
.then(function(token){
    window.localStorage.setItem('browser_token', token);
})
.catch(function(err) {
    console.log('Unable to get permission to notify.', err);
});
