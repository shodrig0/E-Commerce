<?php

use Finite\StateMachine\StateMachine;
use Finite\State\State;
use Finite\Transition\Transition;

class CompraStateMachine
{
    private $stateMachine;

    public function __construct($compra)
    {
        $this->stateMachine = new StateMachine($compra);

        $this->stateMachine->addState(new State('iniciada', State::TYPE_INITIAL));
        $this->stateMachine->addState(new State('en_proceso', State::TYPE_NORMAL));
        $this->stateMachine->addState(new State('completada', State::TYPE_FINAL));
        $this->stateMachine->addState(new State('cancelada', State::TYPE_FINAL));

        $this->stateMachine->addTransition(new Transition('procesar', 'iniciada', 'en_proceso'));
        $this->stateMachine->addTransition(new Transition('completar', 'en_proceso', 'completada'));
        $this->stateMachine->addTransition(new Transition('cancelar', ['iniciada', 'en_proceso'], 'cancelada'));

        $this->stateMachine->initialize();
    }

    public function getStateMachine()
    {
        return $this->stateMachine;
    }
}