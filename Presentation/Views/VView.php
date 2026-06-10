<?php

// Se nel tuo progetto usi i namespace per l'autoloader di Composer, scommenta la riga sotto:
// namespace Presentation\Views;

// Importiamo esplicitamente il namespace nativo di Smarty 5
use Smarty\Smarty;

/**
 * Classe Base View (Astratta)
 * Centralizza la configurazione di Smarty 5.8 per l'intero sottosistema di Presentation.
 */
abstract class VView {
    
    /**
     * L'istanza del motore di template Smarty.
     * È definita 'protected' per consentire alle classi figlie di accedervi direttamente.
     * * @var Smarty
     */
    protected Smarty $smarty;

    /**
     * Costruttore della classe.
     * Si occupa di istanziare Smarty e di impostare i percorsi delle cartelle tecniche.
     */
    public function __construct() {
        // 1. Istanziamo l'oggetto Smarty secondo lo standard Smarty 5
        $this->smarty = new Smarty();

        // 2. Configurazione delle cartelle tramite i metodi Setter (Obbligatori in Smarty 5)
        // I percorsi partono dalla cartella principale (root) del tuo progetto.
        $this->smarty->setTemplateDir('Presentation/smarty-dir/templates/');
        $this->smarty->setCompileDir('Presentation/smarty-dir/templates_c/');
        $this->smarty->setCacheDir('Presentation/smarty-dir/cache/');
        $this->smarty->setConfigsDir('Presentation/smarty-dir/configs/');
    }

    /**
     * Metodo wrapper per associare dati PHP ai segnaposto del template Smarty.
     * Semplifica la sintassi nelle classi figlie.
     *
     * @param string $tpl_var Il nome della variabile che userai nel file .tpl (es. 'prodotti')
     * @param mixed $value Il valore PHP da passare (può essere un valore singolo, un array o un oggetto Doctrine)
     * @return void
     */
    public function assign(string $tpl_var, mixed $value): void {
        $this->smarty->assign($tpl_var, $value);
    }

    /**
     * Metodo wrapper per renderizzare l'interfaccia e inviarla al browser dell'utente.
     *
     * @param string $template Il nome del file del template (es. 'home.tpl' o 'profile/dashboard.tpl')
     * @return void
     */
    public function display(string $template): void {
        $this->smarty->display($template);
    }
}