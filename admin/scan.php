<?php
class scan
{
    private $files;
    private $loggedFiles = array();
    private $filesToLog = array();
    private $fileWarnings = array();

    function __construct()
    {
        global $wpdb;
        $directory = new RecursiveDirectoryIterator(get_home_path(), FilesystemIterator::SKIP_DOTS);
        $this->files = new RecursiveIteratorIterator($directory);
        $this->get_logged();
    }

    public function get_file_status()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "defender_logs";
        $results = $wpdb->get_results("SELECT id,scan_time, file_count FROM $table_name ORDER BY id DESC LIMIT 2");
        $return = array();
        $return['last_checked'] = $results[0]->scan_time?? "No scan information";
        $return['file_count'] = $results[0]->file_count?? "No scan information";
        $return['file_changes'] = $results[1]->file_count?($results[0]->file_count - $results[1]->file_count):"first scan no changes";
        return $return;
    }


    public function log_file_count()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "defender_logs";
        $wpdb->query("INSERT INTO $table_name (scan_time, file_count) VALUES(NOW(),".iterator_count($this->files).");");
    }
    
    public function check_files()
    {
        foreach($this->files as $item):
            if(!isset($this->loggedFiles[MD5($item->getPathName())])):
                $this->filesToLog[] = array('"'.MD5($item->getPathName()).'"', '"'.MD5(file_get_contents($item->getPathname())).'"');
            elseif($this->loggedFiles[MD5($item->getPathName())]!=MD5(file_get_contents($item->getPathname()))):
                $this->fileWarnings[] = '(NOW(), "'.addslashes($item->getPathName()). '")';
            endif;
        endforeach;
        $this->log_files();
        if(!empty($this->fileWarnings)):
            $this->logWarnings();
        endif;
    }

    private function get_logged()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "defender_files";
        $results = $wpdb->get_results("SELECT `path`, `md5` FROM $table_name");
        if(is_array($results)):
            foreach($results as $item):
                $this->loggedFiles[$item->path]=$item->md5;
            endforeach;
        endif;
    }

    public function get_logged_files_count()
    {
        return count($this->loggedFiles);
    }

    private function log_files()
    {
        global $wpdb;
        $values = array();
        foreach($this->filesToLog as $item):
            $values[] = "(NOW(),".implode(',',$item).")";
        endforeach;
        $table_name = $wpdb->prefix . "defender_files";
        $wpdb->query("INSERT INTO $table_name(last_check,`path`,`md5`) VALUES ".implode(',',$values));
    }

    private function logWarnings()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "defender_warnings";

        $wpdb->query("INSERT INTO $table_name(`last_check`, `path`) VALUES ".implode(',',$this->fileWarnings));
    }

    public function get_changed_files()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "defender_warnings";

        $result = $wpdb->get_results("SELECT `last_check`, `path` FROM $table_name");
        $return = '';
        foreach($result as $item):
            $return .= $item->last_check.':'.stripslashes($item->path)."\r\n";
        endforeach;
        return $return;
    }
}
