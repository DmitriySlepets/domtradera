<?php
//session array structure
//when a new tab is added, it will take the following index of current url array. So later we can know which one is
//$_SESSION["tracker"][ current url  ][ tab id]  newer id will be added to the array in an ascending order, not based on their value, so later we can check which tabId came later.

$action = $_POST["action"];
$tabId = $_POST["id"];
$tabUrl = $_POST["url"];

if($action === "check")
{
processTab(tabUrl , $tabId);
}
elseif($action === "closing")
{
closeTab(tabUrl , $tabId) ;
}

/*if this a second tab opened with the same url, then echo the previous tab id and command the client to close self.
*if this the first tab, then store it in session.
*/

function  processTab($tabUrl , $tabId)
{
//if new, then pass it to addTab
// else, check if there is a newer tab opened, then call closeTab
}

function addTab($tabUrl , $tabId)
{
// add a new tab associated with tabUrl -> couter -> tabId
}

function  closeTab($tabUrl , $tabId)
{
//set that $tabUrl with the id to null.
//and ask the client to close the tab.  //echo json_encode(array("responce"=>"closeSelf"))
}