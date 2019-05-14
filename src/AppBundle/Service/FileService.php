<?php

namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FileService extends Filesystem
{
    /** @var string */
    private $projectRootDir;

    /** @var string */
    private $projectDownloadDir;

    /** @var string */
    private $projectTempDir;

    /** @var string */
    private $projectSignDir;

    /** @var ContainerInterface */
    private $container;

    /**
     * Constructor
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->projectRootDir = $this->container->getParameter('project_root_dir');
        $this->projectDownloadDir = $this->container->getParameter('project_download_dir');
        $this->projectTempDir = $this->container->getParameter('project_temp_dir');
        $this->projectSignDir = $this->container->getParameter('project_sign_dir');
    }

    /**
     * Returns absolute path of project's root dir
     * @return bool|string
     */
    public function getProjectRootDir()
    {
        return realpath($this->projectRootDir);
    }

    /**
     * Returns absolute path of project's root dir
     * @return bool|string
     */
    public function getProjectSignDir()
    {
        return realpath($this->projectRootDir . $this->projectSignDir);
    }

    /**
     * Returns absolute path of download directory
     * @return bool|string
     */
    public function getDownloadDir()
    {
        return realpath($this->projectRootDir . $this->projectDownloadDir);
    }

    /**
     * Returns absolute path of temp directory
     * @return bool|string
     */
    public function getTempDir()
    {
        return realpath($this->projectRootDir . $this->projectTempDir);
    }

    /**
     * Returns a "deep folder path" for a given ID
     *
     * The path consist of 2 levels of folders, where the foldername(s) depend
     * on the given ID.
     *
     * Example:
     * ID: 01777 = path: 0/17
     * ID: 14290 = path: 1/42
     * ID: 14295 = path: 1/42
     *
     * @param integer $id
     *
     * @return string The deep folder path without leading/trailing slash
     * @throws \InvalidArgumentException
     */
    public function getDeepFolderNameById($id)
    {
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException(sprintf('The given id "%s" is not numeric.', $id));
        }

        return (string) (int) ($id / 10000) . '/' . (int) (($id % 10000) / 100);
    }

    /**
     * Create a directory if it doesn't already exist
     *
     * @param string $dir Absolute path to directory to create
     *
     * @return boolean
     */
    public function createDir($dir)
    {
        // already exists
        if (is_dir($dir)) {
            return false;
        }

        // is a file
        if (file_exists($dir)) {
            return false;
        }

        // created successfully?
        if(mkdir($dir, 0777, true)) {
            return true;
        }

        // default false
        return false;
    }

    /**
     * Deletes a file, making sure that it exists and is not a directory.
     *
     * @param string $filename Absolute path to the file
     *
     * @return boolean True if file is deleted, otherwise false
     */
    public function deleteFile($filename)
    {
        if (!file_exists($filename) || !is_file($filename)) {
            return false;
        }

        return @unlink($filename);
    }

    /**
     * Deletes a directory, making sure that it exists and is empty.
     *
     * @param string $dir Absolute path to the directory
     *
     * @return boolean True if file is deleted, otherwise false
     */
    public function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return @rmdir($dir);
    }

    /**
     * Moves a file, making sure that it exists.
     *
     * @param string $filename Absolute path to the file
     * @param string $targetname Absolute path to the target file
     *
     * @return boolean True if file is moved, otherwise false
     */
    public function moveFile($filename, $targetname)
    {
        if (!file_exists($filename) || !is_file($filename)) {
            return false;
        }

        $success = false;

        if (copy($filename, $targetname)) {
            $success = $this->deleteFile($filename);
        }

        return $success;
    }

    /**
     * Copies a file, making sure that it exists.
     *
     * @param string $filename Absolute path to the file
     * @param string $targetname Absolute path to the target file
     *
     * @return boolean True if file is copied, otherwise false
     */
    public function copyFile($filename, $targetname)
    {
        if (!file_exists($filename) || !is_file($filename)) {
            return false;
        }

        return copy($filename, $targetname);
    }

    /**
     * Loads data from CSV file into an array and returns it
     * @param string $filename
     * @param string $separator
     * @return array
     * @throws \UnexpectedValueException
     */
    public function loadArrayFromCsv($filename, $separator = ',')
    {
        // load whole CSV
        $csvData = $this->loadCsvFile($filename, $separator);

        // strip first line with columns
        $columns = array_shift($csvData);

        $data = [];

        foreach ($csvData as $line) {
            $row = [];
            foreach ($line as $key => $value) {
                $col = $columns[$key];
                if ($value === 'NULL') {
                    $row[$col] = null;
                } else {
                    $row[$col] = $value;
                }
            }

            $data[] = $row;
        }

        return $data;
    }

    /**
     * Loads column names from CSV file's first line into an array and returns it
     * @param string $filename
     * @param string $separator
     * @return array
     * @throws \UnexpectedValueException
     */
    public function loadColumnNamesFromCsv($filename, $separator = ',')
    {
        // load whole CSV
        $csvData = $this->loadCsvFile($filename, $separator);

        // get first line with columns
        return array_shift($csvData);
    }

    /**
     * Loads data from a CSV-file into a numeric array
     *
     * @param string $filename  The absolute path to the CSV-file
     * @param string $separator The column separator (default ';') in the CSV-file
     *
     * @return array Array of all rows in the CSV-file
     */
    public function loadCsvFile($filename, $separator = ',')
    {
        $handle = fopen($filename, 'r');

        $data = [];
        while (($row = fgetcsv($handle, 5000, $separator)) !== false) {
            $data[] = $row;
        }

        fclose($handle);

        return $data;
    }

    /**
     * Returns the content of given file (absolute path) as base64 encoded string
     *
     * @param string $fileName Absolute path to file
     * @param bool $isLinesWrapped
     *
     * @return string
     */
    public function getBase64FromFile($fileName, $isLinesWrapped = true)
    {
        if ($isLinesWrapped) {
            return chunk_split(base64_encode(file_get_contents($fileName)));
        }

        return base64_encode(file_get_contents($fileName));
    }

    /**
     * Returns the content of given file (absolute path) as base64 encoded string
     *
     * @param string $base64String
     *
     * @return string
     */
    public function getImageUrlFromBase64($base64String)
    {

  /*      $this->deleteDirectory($this->getProjectSignDir()."/img");
exit();*/
        $createImageFolder = $this->getProjectSignDir().'/img';
        if (!file_exists($this->getProjectSignDir())) {
            $this->createDir($this->getProjectSignDir()."/");
        }
        //data:image/png;base64,iVBORw0K
        $this->createDir($createImageFolder);
        $output_file = $createImageFolder."/".rand().".gif";
        $ifp = fopen($output_file, 'wb');
       // $data = explode(',', $base64String);
       // fwrite($ifp, base64_decode($data[1]));
        fwrite($ifp, base64_decode($base64String));
        fclose($ifp);

        return $output_file;
    }


}
