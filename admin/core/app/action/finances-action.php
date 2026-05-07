<?php
/**
* finances-action.php
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add_income") {
    $inc = new IncomeData();
    $inc->source = $_POST["source"];
    $inc->amount = $_POST["amount"];
    $inc->date = $_POST["date"];
    $inc->add();
    Core::redir("./?view=finances");
}

if($opt == "add_expense") {
    $exp = new ExpenseData();
    $exp->category = $_POST["category"];
    $exp->description = $_POST["description"];
    $exp->amount = $_POST["amount"];
    $exp->date = $_POST["date"];
    $exp->add();
    Core::redir("./?view=finances");
}
?>
