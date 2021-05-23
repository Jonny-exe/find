<?php

function clean_block_list($raw_block_list) {
  $clean_block_list = str_replace(PHP_EOL, "", $raw_block_list);
  $clean_block_list = str_replace("\n", "", $clean_block_list );
  $clean_block_list = str_replace("\r", "", $clean_block_list );
  return $clean_block_list;
}
if (isset($_GET["find"])) {
  $cookie_name = "find_block_list";
  if (isset($_GET["block_list"]) and $_GET["block_list"] != "") {
    $raw_block_list = $_GET["block_list"];
    $block_list = clean_block_list($raw_block_list);
    $set_cookie = True;
    if (isset($_COOKIE[$cookie_name])) {
      $new_cookie_value = $block_list . " " . $_COOKIE[$cookie_name];
      $cookie_value = $new_cookie_value;
      $block_list = $new_cookie_value;
    } else {
      $cookie_value = $block_list;
    }
  } else {
    $set_cookie = False;
    if (isset($_COOKIE[$cookie_name])) {
      $block_list = $_COOKIE[$cookie_name];
    } else {
      $block_list = "";
    }
  }
  $new_url = $_GET["find"];
  // header("Location: " . $new_url);

  $adapted_block_list = get_block_list($block_list);

  header("Location: https://duckduckgo.com/" . $new_url . " " . $adapted_block_list);
  // header("refresh: 2; https://duckduckgo.com/" . $new_url . " " . $adapted_block_list);
  if ($set_cookie) {
    print "set cookie";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
  }
  exit;
}

function get_block_list($block_list)
{
  $result_block_list = explode(" ", $block_list);
  $adapted_block_list = "";
  if ($result_block_list[0] != "") {
    foreach ($result_block_list as $block_site) {
      $adapted_block_site = "-site:" . $block_site;
      $adapted_block_list = $adapted_block_list . " " . $adapted_block_site;
    }
  }
  return $adapted_block_list;
}

?>
<!doctype html>
<html>

<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <script src="js/index.js" type="module" defer></script>
  <title>Find</title>
</head>

<body>
  <h1>Find</h1>
  <form>
    <input type="input" class="form-control" placeholder="Find" name="find" aria-describedby="basic-addon1">
    <textarea type="text" name="block_list" placeholder="Add to block list" class="form-control" class="block-list"></textarea>
  </form>
  <div id="block-list-wrapper" class="hide">
    <?php 
    if (isset($_COOKIE["find_block_list"]))  {
      $block_list = $_COOKIE["find_block_list"];
      $block_list_array = explode(" ", $block_list);
      echo "<table class='table table-bordered'>";
      foreach ($block_list_array as $block_site) {
        echo "<tr><td>".$block_site."</td></tr>";
      }
      print "</table>";
    }
    ?>
  </div>
  <button type="button" id="block-list-button" class="btn btn-default">Block list</button>
</body>
<style>
  html {
    height: 100%;
  }


  td {
    text-align: center;
  }

  :focus {
    outline: none;
  }

  body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1% 30%;
    height: 100%;
  }

  div {
    padding: 0;
    width: 100%;
  }

  form {
    width: 100%;
  }

  .hide {
    display: none;
  }

  button {
    margin: 1% 0%;
  }

  textarea {
    margin: 1% 0%;
    resize: none;
  }
</style>

</html>