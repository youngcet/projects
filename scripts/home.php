<?php
    require ('GeneratePage.php');
    
    class HomePage
    {
        use GeneratePage;
        
        public function __construct()
        {
            $items = array('milk' => 20, 'bread' => 15);
            $amount = 0;
            foreach ($items as $key => $value)
                {
                    $i .= '<tr>
                          <td width="80%" class="purchase_item"><span class="f-fallback">'.$key.'<br/></span></td>
                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">R'.$value.'</span></td>
                        </tr>';
                    
                    $amount = $amount + $value;
                }
            
            $data = array(
                            '{{username}}' => 'Yung Cet', 
                            '{{date}}' => '2020-07-04', '<%items%>' => $i, 
                            '{{amount}}' => 'R'.number_format( sprintf( "%.2f", $amount ), 2, '.', '' ),
                            '{{emailaddress}}' => 'someemailaddress'
                        );
                        
            echo $this->render('pages/index.html', $data);
        }
    }
    
    new HomePage;
    
?>