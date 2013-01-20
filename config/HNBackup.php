<?php
/**
 * Quan MT - Brodev Software
 * www.brodev.com
 */

use Gaufrette\Filesystem;
use Gaufrette\Adapter\AmazonS3 as AmazonS3Adapter;
use \AmazonS3 as AmazonClient;

class HNBackup
{

    protected $tmpDir;

    protected $settings;

    protected $files = array();

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

        // push files
        $this->pushToBackup();

    }

    /**
     * Backup database
     */
    protected function backupDB()
    {
        $targetFile = $this->tmpDir . 'db.sql';
        $targetFileGz = $this->tmpDir . 'db.tgz';

        $this->files[] = $targetFileGz;

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
        $this->files[] = $targetFile;

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

    /**
     * Push files to backup storage
     */
    protected function pushToBackup()
    {
        $options = array(
            'key' => $this->settings['s3_access_key'],
            'secret' => $this->settings['s3_secret_access_key'],
        );
        $s3Client = new AmazonClient($options);

        $s3Adapter = new AmazonS3Adapter($s3Client, $this->settings['s3_bucket']);

        $filesystem = new Filesystem($s3Adapter);

        $name = $this->getBackUpName();

        foreach ($this->files as $file) {
            $backedFile = $this->settings['s3_path'] . '/' . $name . '/' . basename($file);
            $filesystem->write($backedFile, file_get_contents($file));
        }

        // delete tmp folder
        exec('rm -rf ' . $this->tmpDir);

    }
}
