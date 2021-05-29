<?php

namespace Tests\Feature;

use Tests\TestCase;

class SchedulerTest extends TestCase
{

    /**
     * Para efeitos de avaliação esse método esta sendo implementado no proprio arquivo de testes
     * 
     * @param array $selected (Horario de inicio e fim em que se deseja consultar)
     * @param array $blocked (Horario de inicio e fim que já está ocupado)
     * 
     * @return bool
     */
    private function isBusy($selected, $blocked)
    {
        return true;
    }


    /**
     * @test
     */
    public function selected_equal_blocked()
    {
        $selected = $blocked = ['start' => '10:00', 'end' => '11:00'];

        $this->assertTrue($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_before()
    {
        $selected = ['start' => '07:00', 'end' => '08:00'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertFalse($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_after()
    {
        $selected = ['start' => '11:00', 'end' => '12:00'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertFalse($this->isBusy($selected, $blocked));
    }


    /**
     * @test
     */
    public function selected_between_blocked()
    {
        $selected = ['start' => '09:01', 'end' => '09:59'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertTrue($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_initial_between_blocked()
    {
        $selected = ['start' => '09:30', 'end' => '10:30'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertTrue($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_final_between_blocked()
    {
        $selected = ['start' => '08:30', 'end' => '09:30'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertTrue($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_before_blocked()
    {
        $selected = ['start' => '08:00', 'end' => '09:00'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertFalse($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function selected_after_blocked()
    {
        $selected = ['start' => '10:00', 'end' => '11:00'];

        $blocked = ['start' => '09:00', 'end' => '10:00'];

        $this->assertFalse($this->isBusy($selected, $blocked));
    }

    /**
     * @test
     */
    public function blocked_between_selected()
    {
        $selected = ['start' => '11:00', 'end' => '12:00'];

        $blocked = ['start' => '11:15', 'end' => '12:45'];

        $this->assertTrue($this->isBusy($selected, $blocked));
    }
}
