<p align="center"><img src="https://www.webofiice.ro/assets/img/components/logo-AuthSocial.png"></p>

<p align="center"> 
<a href="https://github.com/LaServici/Authsocial/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/LaServici/Authsocial"></a>
<a href="https://github.com/LaServici/Authsocial/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/LaServici/Authsocial"></a>
<a href="https://github.com/LaServici/Authsocial/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/LaServici/Authsocial"></a>
<a href="https://github.com/LaServici/Authsocial/blob/master/LICENSE"><img alt="GitHub license" src="https://img.shields.io/github/license/LaServici/Authsocial"></a>
<a href="https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2FLaServici%2FAuthsocial"><img alt="Twitter" src="https://img.shields.io/twitter/url/https/github.com/LaServici/Authsocial?style=social"></a>
</p>

## Introducere

Laservici AuthSocial este o aplicatie pentru Laravel care oferă o interfață expresivă și fluentă pentru autentificarea OAuth cu furnizorii de autentificare socială (Facebook, Twitter, Google, LinkedIn, GitHub, GitLab, Bitbucket etc). Acesta se ocupă aproape de tot codul de autentificare socială boilerplate pe care îl doriți.


## Documentația oficială

Pe lângă autentificarea tipică bazată pe formular, Laravel oferă de asemenea o modalitate simplă și convenabilă de autentificare cu furnizorii OAuth utilizând [Laservici AuthSocial](https://github.com/LaServici/AuthSocial). AuthSocial susține în prezent autentificarea cu furnizorii sociali.

Pentru a începe cu AuthSocial, utilizați Composer pentru a adăuga pachetul de dependențe în proiect:

```bath
    composer require laservici/authsocial
```

### Configurare

După instalarea bibliotecii LaServici, includeți `Laservici\Authsocial\AuthSocialServiceProvider` în interiorul grupului `providers` din fișierul de configurare `config/app.php`:

```php
'providers' => [
       ......
    // Application Service Providers...
       ......
       Laservici\Authsocial\AuthSocialServiceProvider::class,
],
```

De asemenea, adăugați fragmentul `AuthSocial` in interiorul grupului `aliases` din fișierul de configurare `app` (config/app.php):

```php
'aliases' => [
    //  Class Aliases...
      .....
     'AuthSocial' => Laservici\Authsocial\Facades\AuthSocial::class,
```

De asemenea, va trebui să adăugați acreditări pentru serviciile OAuth pe care aplicația dvs. le utilizează. Aceste acreditări ar trebui plasate în fișierul de configurare `config/services.php` și ar trebui să utilizeze cheia `facebook`,` twitter`, `linkedin`,` google`, `github` sau` bitbucket`, solicitată în funcție de cererea furnizorilor.
De exemplu:

```php
    'github' => [
        'client_id'     => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect'      => env('APP_URL').'/your-callback-url',
    ],
```
### Utilizare de bază

Apoi, sunteți gata să autentificați utilizatorii! Veți avea nevoie de două rute: una pentru redirecționarea utilizatorului la furnizorul de servicii OAuth și altul pentru primirea apelului de la furnizor după autentificare. Vom accesa AuthSocial folosind fațada `Authsocial`:

```php

<?php

namespace App\Http\Controllers\Auth;

use Authsocial;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Authsocial::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Authsocial::driver('github')->user();

        // $user->token;
    }
}
```

Metoda `redirect` are grijă să trimită utilizatorul la furnizorul OAuth, în timp ce metoda `user` va citi cererea de intrare și va prelua informațiile utilizatorului de la furnizor. Înainte de a redirecționa utilizatorul, puteți seta și `scopes` la cerere utilizând metoda `scope`. Această metodă va suprascrie toate domeniile existente:  

```php
    return Authsocial::driver('github')
            ->scopes(['scope1', 'scope2'])->redirect();
```

Desigur, va trebui să definiți rute pentru metodele `controller methods`:

```php
   Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
   Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
```

Un număr de furnizori OAuth acceptă parametrii opționali în cererea de redirecționare. Pentru a include toți parametrii opționali în cerere, apelați metoda `with` cu o matrice asociativă:

```php
  return Authsocial::driver('github')
            ->with(['hd' => 'example.com'])->redirect();
```

Atunci când utilizați metoda `with`, aveți grijă să nu transmiteți cuvinte cheie rezervate, cum ar fi `state` sau `response_type`.

#### Metoda Stateless pentru Autentificare

Metoda `stateless` poate fi utilizată pentru a dezactiva verificarea stării sesiunii. Acest lucru este util atunci când adăugați autentificarea socială la un API:

```php
  return Authsocial::driver('github')->stateless()->user();
```


#### Recuperarea detaliilor utilizatorului

Odată ce aveți o instanță de utilizator, puteți obține câteva detalii despre utilizator:

```php
  $user = Authsocial::driver('github')->user();

// OAuth Two Providers
   $token = $user->token;
   $refreshToken = $user->refreshToken; // not always provided
   $expiresIn = $user->expiresIn;

// OAuth One Providers
   $token = $user->token;
   $tokenSecret = $user->tokenSecret;

// All Providers
   $user->getId();
   $user->getNickname();
   $user->getName();
   $user->getEmail();
   $user->getAvatar();
```

#### Recuperarea detaliilor utilizatorului folosind Token

Dacă aveți deja un token de acces valabil pentru un utilizator, puteți să le recuperați folosind metoda `userFromToken`:

```php
  $user = Authsocial::driver('github')->userFromToken($token);
```

## Liciență

Laservici AuthSocial este un software open-source licențiat sub [MIT license](http://opensource.org/licenses/MIT)
