<?php
require_once(DEFENDER_ROOT . '/admin/scan.php');
$scan = new scan();

if(isset($_GET['scan'])):
    switch($_GET['scan']):
        case 'fim':
            $scan->log_file_count();
        break;
        case 'full':
            $scan->check_files();
        break;
    endswitch;
endif;

$file_status =  $scan->get_file_status();
?>
<h1>Welcome to Defender<h1>
<div class="row">
    <p>Defender is a simple FIM (file integrity manager) and file checker.</p>
</div>
<div style="display:flex;">
    <div class="panel">
        <h4>File Status</h4>
        <?php ?>
        <span>Last Check: <?php echo $file_status['last_checked'] ?></span>
        <span>Number of files: <?php echo $file_status['file_count'] ?></span>
        <span>File changes: <?php echo $file_status['file_changes'] ?></span>
    </div>
    <div class="panel">
    
        <h4>Advanced Checks:</h4>
        <span>Files Monitored: <?php echo $scan->get_logged_files_count(); ?> </span>
    </div>
    <div class="panel">
        <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=defender-plugin&scan=fim"; ?>">FIM Check</a>
        <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=defender-plugin&scan=full"; ?>">Adv Check</a>
    </div>
</div>
<div style="display:flex;">
    <div class="panel">
        <h4>File Change Log</h4>
        <textarea lines="10" style="width:100%; height:200px;">
            <?php echo $scan->get_changed_files(); ?>
        </textarea>
    </div>
</div>
<style>
.panel{flex-grow: 1;padding: 15px;border: 1px solid #e2e2e2; margin: 15px; border-radius: 2px;}
.panel h4{margin:5px 0 10px;}
.panel span{display:block; font-size:16px; line-height:16px;}
</style>