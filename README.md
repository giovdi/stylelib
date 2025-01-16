# Universal StyleLib

La libreria definitiva per creare componenti velocemente con Laravel 11

La documentazione ufficiale è disponibile su [stylelib.pixelstyle.it](https://stylelib.pixelstyle.it)

## Documentazione tecnica

WIP: documentazione tecnica in fase di riscrittura

Blade UI

composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
composer require blade-ui-kit/blade-ui-kit
php artisan vendor:publish --tag=blade-ui-kit-config

npm run dev

## Ambiente di sviluppo

Dopo aver fatto il setup di un nuovo progetto Laravel, effettuare le seguenti operazioni:
1. fare il clone di questo progetto direttamente nella root di laravel
```
git clone https://github.com/giovdi/stylelib.git
```
3. aggiungere a `bootstrap/providers.php` la seguente riga:
```
return [
    ...
    \Pixelstyle\Stylelib\Providers\StyleServiceProvider::class,
]
```

2. aggiungere nel `composer.json` del progetto il seguente blocco
```
"autoload": {
    "psr-4": {
        ...
        "Pixelstyle\\Stylelib\\": "stylelib/src/"
    }
},
```

3. eseguire il seguente comando per ricaricare composer
```
composer dump
```

4. per lasciare npm in ascolto dei cambiamenti, utilizza
```
npm dev
```