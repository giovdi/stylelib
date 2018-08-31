# Universal StyleLib

La libreria definitiva usabile sia con Laravel 5 sia Standalone

## Temi disponibili

* Inspinia
* AdminLTE
* Angle

## Installazione

La libreria è facilmente installabile con composer in 2 passi:

1. aggiungendo il repository al composer.json

```
"repositories": [
	{
		"type": "vcs",
		"url": "http://athena.pixelstyle.it:7990/scm/dsl/universal-stylelib.git"
	}
]
```

2. eseguendo `composer require deploystudio/universal-stylelib`

## Uso con Laravel

Per usare la libreria con laravel, bisogna aggiungere i seguenti alias al `config/app.php`:

### AdminLTE
```
'Box' => 'DeployStudio\Style\Adminlte\Box',
'BoxStat' => 'DeployStudio\Style\Adminlte\BoxStat',
'Form' => 'DeployStudio\Style\Adminlte\NForm',
'Table' => 'DeployStudio\Style\Adminlte\Table',
```

### Inspinia
```
'Box' => 'DeployStudio\Style\Adminlte\Box',
'BoxStat' => 'DeployStudio\Style\Adminlte\BoxStat',
'Form' => 'DeployStudio\Style\Adminlte\NForm',
'Table' => 'DeployStudio\Style\Adminlte\Table',
```

### Angle
```
'BoxStat' => 'DeployStudio\Style\Adminlte\BoxStat',
'Box' => 'DeployStudio\Style\Adminlte\Box',
'Form' => 'DeployStudio\Style\Adminlte\NForm',
'Table' => 'DeployStudio\Style\Adminlte\Table',
```

## Uso standalone

Per usare la libreria standalone, dopo averla installata via Composer, basta includere l'autoload generale di composer `require('vendor/autoload.php');` se non è stato già fatto e aggiungere `use DeployStudio\Style\[nometema]\[elemento];` dove necessario.