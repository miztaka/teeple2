<?php
class LearningTest extends UnitTestCase
{
    public function testObjectVars() {
        
        $obj = new StdClass();
        $obj->aa = 'foo';
        $obj->bb = 'bar';
        
        var_dump(get_object_vars($obj));
        
        $obj = new ActionChild();
        $obj->aa = 'foo';
        $obj->bb = 'bar';
        
        var_dump(get_object_vars($obj));
    }
}

class ActionChild extends Teeple_ActionBase
{
    
}

?>
