# Universal StyleLib

La libreria definitiva usabile sia con Laravel 5 sia Standalone

La documentazione ufficiale è disponibile su [doc.dev.pixelstyle.it](http://doc.dev.pixelstyle.it)

## Documentazione tecnica

Qui è descritta una breve documentazione tecnica che regola gli sviluppi futuri.

### Form e FormGroup class

La Form class e la FormGroup class si dividono in 3 files base e 2 files per tema

* **NOMETEMA/NForm.php**: definisce lo stile di base dei campi nella Form class
* **NOMETEMA/NFormGroup.php**: definisce lo stile di base dei campi nella FormGroup class
* **Base/NForm.php**: imposta le opzioni specifiche della Form class e rimanda alla FormBase per impostare le opzioni generali
* **Base/NFormGroup.php**: imposta le opzioni specifiche della FormGroup class e rimanda alla FormBase per impostare le opzioni generali
* **Base/NFormBase.php**: imposta le opzioni di base valide sia per la Form class sia per la FormGroup class

#### Estensione classi

DeployStudio\Style\NOMETEMA\NForm  
ext. DeployStudio\Style\Base\NForm  
ext. DeployStudio\Style\Base\NFormBase

DeployStudio\Style\NOMETEMA\NFormGroup  
ext. DeployStudio\Style\Base\NFormGroup  
ext. DeployStudio\Style\Base\NFormBase

#### Concetto base

La creazione dei campi è generalmente divisa in due fasi: Base e Build.

* Nella funzione Base vengono definite tutte le opzioni utili a generare il campo
* Nella funzione Build viene generato il campo

Potrebbero essere necessarie altre fasi, sono di seguito analizzate.

#### Campo input

```
use DeployStudio\Style\NOMETEMA;
NForm::input(...);
NFormGroup::input(...);

Gerarchia delle funzioni usate:
--- Base\NForm::input();             // entrypoint
  |-- Base\NFormBase::inputBase();   // definisce opzioni di campo e di stampa
  |-- NOMETEMA\NForm::inputBuild();  // stampa il campo
```

#### Campi email, password, file, datepicker, datetimepicker, clockpicker e touchspin (varianti input)

```
use DeployStudio\Style\NOMETEMA;
NForm::email(...);
NFormGroup::email(...);

Gerarchia delle funzioni usate:
--- Base\NForm::email();               // entrypoint
  |-- Base\NFormBase::email();         // definisce opzioni di campo aggiuintive
  |-- Base\NForm::input();             // tratta il campo come input normale
    |-- Base\NFormBase::inputBase();   // definisce opzioni di campo e di stampa
    |-- NOMETEMA\NForm::inputBuild();  // stampa il campo
```

#### Campo textarea

```
use DeployStudio\Style\NOMETEMA;
NForm::textarea(...);
NFormGroup::textarea(...);

Gerarchia delle funzioni usate:
--- Base\NForm::textarea();             // entrypoint
  |-- Base\NFormBase::textareaBase();   // definisce opzioni di campo e di stampa
  |-- NOMETEMA\NForm::textareaBuild();  // stampa il campo
```

#### Campo wysiwyg (variante textarea)

```
use DeployStudio\Style\NOMETEMA;
NForm::wysiwyg(...);
NFormGroup::wysiwyg(...);

Gerarchia delle funzioni usate:
--- Base\NForm::wysiwyg();                // entrypoint
  |-- Base\NFormBase::wysiwyg();          // definisce opzioni di campo aggiuintive
  |-- Base\NForm::textarea();             // tratta il campo come textarea normale
    |-- Base\NFormBase::textareaBase();   // definisce opzioni di campo e di stampa
    |-- NOMETEMA\NForm::textareaBuild();  // stampa il campo
```

#### Campo checkbox (singola)

```
use DeployStudio\Style\NOMETEMA;
NForm::checkbox(...);
NFormGroup::checkbox(...);

Gerarchia delle funzioni usate:
--- Base\NForm::checkbox();                 // entrypoint
  |-- Base\NForm::checkboxes();             // tratta la checkbox come multipla
    |-- Base\NFormBase::checkboxesBase();   // definisce opzioni di campo e di stampa
    | |-- NOMETEMA\NForm::checkboxBuild();  // stampa la singola checkbox
    |-- NOMETEMA\NForm::checkboxesBuild();  // stampa il contenitore delle checkbox
```

#### Campo checkbox (multipla)

```
use DeployStudio\Style\NOMETEMA;
NForm::checkboxes(...);
NFormGroup::checkboxes(...);

Gerarchia delle funzioni usate:
--- Base\NForm::checkboxes();             // entrypoint
  |-- Base\NFormBase::checkboxesBase();   // definisce opzioni di campo e di stampa
  | |-- NOMETEMA\NForm::checkboxBuild();  // stampa la singola checkbox
  |-- NOMETEMA\NForm::checkboxesBuild();  // stampa il contenitore delle checkbox
```

#### Campo radio

```
use DeployStudio\Style\NOMETEMA;
NForm::radio(...);
NFormGroup::radio(...);

Gerarchia delle funzioni usate:
--- Base\NForm::radio();                    // entrypoint
  |-- Base\NForm::checkboxes();             // tratta i radio button come checkbox di tipo radio
    |-- Base\NFormBase::checkboxesBase();   // definisce opzioni di campo e di stampa
    | |-- NOMETEMA\NForm::checkboxBuild();  // stampa la singola checkbox
    |-- NOMETEMA\NForm::checkboxesBuild();  // stampa il contenitore delle checkbox
```

#### Campo select

```
use DeployStudio\Style\NOMETEMA;
NForm::select(...);
NFormGroup::select(...);

Gerarchia delle funzioni usate:
--- Base\NForm::select();             // entrypoint
  |-- Base\NFormBase::selectBase();   // definisce opzioni di campo e di stampa
  |-- NOMETEMA\NForm::selectBuild();  // stampa il campo
```

#### Campo selectAjax

```
use DeployStudio\Style\NOMETEMA;
NForm::selectAjax(...);
NFormGroup::selectAjax(...);

Gerarchia delle funzioni usate:
--- Base\NForm::selectAjax();           // entrypoint
  |-- Base\NFormBase::selectAjaxBase()  // prepara la funzione di processData
  |-- Base\NForm::select();             // tratta la funzione come una select normale
    |                                   // con la differenza che i valori passati in $values
    |                                   // sono precaricati e preselezionati
    |-- Base\NFormBase::selectBase();   // definisce opzioni di campo e di stampa
    |-- NOMETEMA\NForm::selectBuild();  // stampa il campo
```

#### Campo selectRS

```
use DeployStudio\Style\NOMETEMA;
NForm::selectRS(...);
NFormGroup::selectRS(...);

Gerarchia delle funzioni usate:
--- Base\NForm::selectRS();             // entrypoint
  |-- Base\NFormBase::selectRSBase()    // elabora i valori per normalizzare il $values
  |-- Base\NForm::select();             // tratta la funzione come una select normale
    |-- Base\NFormBase::selectBase();   // definisce opzioni di campo e di stampa
    |-- NOMETEMA\NForm::selectBuild();  // stampa il campo
```

#### Testo piano

```
use DeployStudio\Style\NOMETEMA;
NForm::html(...);
NFormGroup::html(...);

Gerarchia delle funzioni usate:
--- NOMETEMA\NForm::html();     // stampa l'html
```

#### Campo hidden, Fill form e tutte le funzioni fin qui non indicate

Tutte le altre funzioni fin qui non indicate sono definite nella classe `Base\NFormBase`