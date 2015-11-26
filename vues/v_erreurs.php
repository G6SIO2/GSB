<div class ="erreur">
<ul>
<?php 
foreach($_REQUEST['erreurs'] as $erreur)
	{
      echo "<li>$erreur</li>";
	}      
 ?>
    </ul></div>
<div class="message">
<?php
if(isset($_REQUEST['message']))
{
foreach($_REQUEST['message'] as $message)
	{
      echo "<a>$message</a><br />";
	}
}
?>
</div>
