<?php
/**
 * Quan MT - Brodev Software
 * www.brodev.com
 */

class HNBackup
{

    protected $tmpDir;

    protected $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Initialize new backup
     */
    public function initialize()
    {
        $this->tmpDir = TMP_DIR . $this->generateRandom() . '/';
        // create dir if needed
        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir);
        }
    }

    /**
     * Generate a random string
     * @return string
     */
    protected function generateRandom()
    {
        return md5(time() . uniqid() . mt_rand(100, 9999));
    }

    /**
     * Start backing up
     */
    public function start()
    {
        // backup db
        $this->backupDB();

        // back up files
        $this->backupFiles();

    }

    /**
     * Backup database
     */
    protected function backupDB()
    {
        $targetFile = $this->tmpDir . 'db.sql';
        $cmd = $this->settings['mysqldump_path']
            . ' -h ' . $this->settings['mysql_host']
            . ' -u ' . $this->settings['mysql_user']
            . ' -p' . $this->settings['mysql_password']
            . ' ' . $this->settings['mysql_name']
            . ' > ' . $targetFile;

        exec($cmd);

        exec('cd ' . $this->tmpDir);

        $cmd = $this->settings['tar_path'] . '  -zcf db.tgz db.sql';
        exec('cd ' . $this->tmpDir . ';' . $cmd);

        // delete file
        exec('rm -f ' . $targetFile);

    }

    /**
     * Zip all files and backup
     */
    protected function backupFiles()
    {
        $targetFile = $this->tmpDir . 'files.tgz';

        $cmd = 'cd ' . $this->settings['path'] . ';' . $this->settings['tar_path'];

        $excludedPaths = trim($this->settings['excluded_paths']);
        if (empty($excludedPaths)) {
            $excludedPaths = array();
        } else {
            $excludedPaths = explode(';', $excludedPaths);
        }

        foreach ($excludedPaths as $path) {
            $path = trim($path);
            $cmd .= ' --exclude="./' . $path . '"';
        }

        $cmd .= ' -zcf ' . $targetFile . ' ./';

        exec($cmd);

    }

    /**
     * Get backup name
     * @return string
     */
    protected function getBackUpName()
    {
        return date('Y-m-d-h-m-i') . '-' . $this->generateRandom();
    }

}
