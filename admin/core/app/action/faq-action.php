<?php
/**
* faq-action.php
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add") {
    $f = new FaqData();
    $f->question = $_POST["question"];
    $f->answer = $_POST["answer"];
    $f->add();
    Core::redir("./?view=faq");
}

if($opt == "del") {
    $f = FaqData::getById($_GET["id"]);
    $f->del();
    Core::redir("./?view=faq");
}
?>
