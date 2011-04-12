<img src="<?php 
if(isset($picture))
    echo $picture;
else
    echo "http://www.makefive.com/media/images/placeholder/default_user.jpg";
?>" height="256" width="256" /> <br>

<?php
$this->load->model('User_model');
$this->load->library('session');
$userid = $this->session->userdata('userid');
        if($this->User_model->is_trusted_helper($userid)){
               echo anchor('login/logout', 'Log out') . '<br>';
               echo anchor('account', 'View/Modify Profile') . '<br>';
               echo anchor('history', 'View History') . '<br>';
               echo anchor('shoppingCart', 'Shopping Cart') . '<br>';
               echo anchor('mod_item', 'Add/Modify Item') . '<br>';
               echo anchor('view_transaction', 'View Transaction History') . '<br>';
               echo anchor('view_trans_date', 'View History of Transactions for a Date Range') . '<br>';
               echo anchor('currentInventory', 'View Current Inventory') . '<br>';
        }
       
        else if($this->User_model->is_adult_helper($userid){
               echo anchor('login/logout', 'Log out') . '<br>';
               echo anchor('history', 'View History') . '<br>';
               echo anchor('shoppingCart', 'Shopping Cart') . '<br>';
               echo anchor('view_transaction', 'View Transaction History') . '<br>';
               echo anchor('view_trans_date', 'View History of Transactions for a Date Range') . '<br>';
               echo anchor('currentInventory', 'View Current Inventory') . '<br>';
       }

        else if($this->User_model->is_teen_helper($userid){
               echo anchor('login/logout', 'Log out') . '<br>';
               echo anchor('shoppingCart', 'Shopping Cart') . '<br>';
               echo anchor('currentInventory', 'View Current Inventory') . '<br>';
       }

        else if($this->User_model->is_child($userid){
               echo anchor('login/logout', 'Log out') . '<br>';
               echo anchor('shoppingCart', 'Shopping Cart') . '<br>';
               echo anchor('currentInventory', 'View Current Inventory') . '<br>';
       }
?>
