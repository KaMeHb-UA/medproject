(()=>{const require=(()=>{return exports=>{exports=(url=>{return{url,xhr:new XMLHttpRequest()}})(exports);return new Promise((__filename,__dirname)=>{exports.xhr.open('GET',exports.url,true);exports.xhr.send();exports.xhr.onreadystatechange=()=>{if(exports.xhr.readyState!=4)return;if(exports.xhr.status!=200)__dirname(new Error(`Cannot require module ${exports.url}: ${exports.xhr.status} (${exports.xhr.statusText})`));else{try{let module={exports:{}};eval(`Promise.resolve((async({__filename,__dirname,exports})=>{${exports.xhr.responseText}})({__filename:${JSON.stringify(exports.url)},__dirname:${JSON.stringify((a=>{a.pop();return a.join('/')})(exports.url.split('/')))},exports:new Proxy(module.exports,{})})).then(()=>{__filename(module.exports)})`);}catch(e){__dirname(e)}}}})}})(),__filename=(a=>{return `${a[a.length-3]}://${a[a.length-2]}`})((new Error('')).stack.split(/(\w+):\/\/(\S+):\d+:\d+/)),__dirname=(a=>{a.pop();return a.join('/')})(__filename.split('/'));(async()=>{
    // Пример: require('https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js').then($=>{console.log($('body'))})
    // Код перенести в эту оболочку. Доступна нестандартная реализация функции require (возвращает промис, который резолвится в экспортируемый объект указанного модуля)
    const baseuri = `${location.origin}/project`;
        [{html, body, is, isAll, $, Cookies, http, _}, md5] = await Promise.all([
            require('https://cdn.jsdelivr.net/gh/FavoriStyle/FoodGuide@74d37d14f76e3ebd0a040b63dcff47f24b7130af/assets/js/env.js'),
            require(`${baseuri}/md5.js`),
        ]);
    if(is('.login-page')){
        async function auth(login, pass){
            return JSON.parse(await http.get(`auth.php?login=${encodeURIComponent(login)}&pass_h=${md5(pass)}&ua=${encodeURIComponent(navigator.userAgent)}`)).salt
        }
        async function reg(login, pass, role){
            return JSON.parse(await http.get(`reg.php?login=${encodeURIComponent(login)}&pass_h=${md5(pass)}&role=${encodeURIComponent(role)}`)).res
        }
        $('#login')[0].addEventListener('submit', event => {
            event.preventDefault();
            (async () => {
                var salt = await auth($('#login input[name="login"]')[0].value, $('#login input[name="pass"]')[0].value);
                if(salt){
                    Cookies.set('salt', salt);
                    location.href = `${baseuri}/user_panel.php`
                }
            })();
        });
        $('#register')[0].addEventListener('submit', event => {
            event.preventDefault();
            (async () => {
                var loginpass = [$('#register input[name="login"]')[0].value, $('#register input[name="pass"]')[0].value],
                    role = $('#register select[name="role"]')[0].value;
                if(await reg(...loginpass, role)){
                    var salt = await auth(...loginpass);
                    if(salt){
                        Cookies.set('salt', salt);
                        location.href = `${baseuri}/user_panel.php`
                    }
                } else alert('Такой логин уже существует, придумайте другой')
            })();
        })
    } else if(is('.user-panel')){
        //$('body')[0].innerHTML = Cookies.get('salt');
    } else if(is('.prelogin-page')){
        $('#metadata')[0].addEventListener('submit', event => {
            event.preventDefault();
            (async () => {
                if(/\d{4}-\d{2}-\d{2}/.test($('#metadata input[name="birthday"]')[0].value)) event.target.submit();
                else alert('Введите дату рождения');
            })();
        })
    }
})()})()