<?php

class Botgento_Base_Model_System_Config_Source_Buttonsize
{

    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'xlarge',
                'label' => 'Xlarge',
            ),
            array(
                'value' => 'standard',
                'label' => 'Standard',
            ),
            array(
                'value' => 'large',
                'label' => 'Large',
            )
        );
    }
}