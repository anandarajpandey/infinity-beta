<?php

/**
 * Class File
 * Collection of method for file related tasks. 
 * @copyright     Copyright (c) Ananda Raj Pandey <vendornepala@gmail.com>.
 * Redistributions of files must retain the above copyright notice.
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Ananda Raj Pandey <vendornepala@gmail.com>
 * @package I.Filesystem
 * 
 */
class File {

    /**
     *  Path for File.
     * @var string 
     */
    public $filePath = Null;

    /**
     * Permission for given path.
     * @var int
     */
    public $mode = '0644';

    /**
     * Get current path.
     * @return string
     */
    public function pwd($filePath = false) {
        if (!$filePath && !$this->filePath)
            $filePath = getcwd();

        if (!$filePath)
            $filePath = $this->filePath;
        return $filePath;
    }

    /**
     * create new file.
     * @param  string  $filePath
     * @return bool
     */
    public function create($filePath = false, $mode = '0644') {
        $filePath = $this->pwd($filePath);
        if (!$this->exists($filePath)) {
            if (touch($filePath)) {
                $this->chmod($filePath, $mode);
                return true;
            }
        }
        return false;
    }

    /**
     * get the content of the file.
     * @param  string  $filePath
     * @return bool
     */
    public function read($filePath = false) {
        $filePath = $this->pwd($filePath);
        if (!$this->exists($filePath))
            return false;
        return file_get_contents($filePath);
    }

    /**
     * Write to the file.
     * @param string $filePath
     * @param string $data
     */
    public function write($filePath, $data) {
        return file_put_contents($filePath, $data);
    }

    /**
     * Append to a file.
     * @param  string  $filePath
     * @param  string  $data
     * @return int
     */
    public function append($filePath, $data) {
        return file_put_contents($filePath, $data, FILE_APPEND);
    }

    /**
     * move file to new desintation
     * @param  string  $filePath
     * @param  string  $destination
     * @param bool $overwrite 
     * @return void
     */
    public function move($filePath, $destination, $overwrite = false) {
        if (!$this->exists($filePath) || (is_file($destination) && !$overwrite))
            return false;
        else
            return rename($filePath, $destination);
    }

    /**
     * Copy a file to a destination.
     * @param  string  $filePath
     * @param  string  $destination
     * @param bool $overwrite 
     * @return void
     */
    public function copy($filePath, $destination, $overwrite = false) {
        if (!$this->exists($filePath) || (is_file($destination) && !$overwrite))
            return false;
        else
            return copy($filePath, $destination);
    }

    /**
     * check if file exist
     * @param string $filePath .
     * @return bool
     */
    public function exists($filePath = false) {
        $filePath = $this->pwd($filePath);
        return (file_exists($filePath) && is_file($filePath));
    }

    /**
     * Get the file last modified time
     * @param string $filePath .
     * @return bool
     */
    public function lastModified($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return filemtime($filePath);
        else
            return false;
    }

    /**
     * Delete the file.
     * @param  string  $filePath
     * @return bool
     */
    public function delete($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return @unlink($filePath = false);
        else
            return false;
    }

    /**
     * Get the file name
     * @param string $filePath .
     * @return bool
     */
    public function name($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return pathinfo($filePath, PATHINFO_FILENAME);
        return false;
    }

    /**
     * Get the file extension
     * @param string $filePath .
     * @return bool
     */
    public function ext($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return pathinfo($filePath, PATHINFO_EXTENSION);
        else
            return false;
    }

    /**
     * Check if file file type.
     * @param string $filePath file to check.
     * @return bool
     */
    public function fileType($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return filetype($filePath);
        return false;
    }

    /**
     * Check if file is Executable or not.
     * @param string $filePath file to check.
     * @return bool
     */
    public function isExecutable($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return is_executable($filePath);
        else
            return false;
    }

    /**
     * Check if file is readable or not.
     * @param string $filePath file to check.
     * @return bool
     */
    public function isReadable($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return is_readable($filePath);
        else
            return false;
    }

    /**
     * Check if file is writeable or not.
     * @param string $filePath file to check.
     * @return bool
     */
    public function isWriteable($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return is_writable($filePath);
        else
            return false;
    }

    /**
     * Check if path is file path.
     * @param string $filePath file to check.
     * @return bool
     */
    public function isFile($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return is_file($filePath);
        else
            return false;
    }

    /**
     * Get the size of file.
     * @param string $filePath file to check.
     * @return bool
     */
    public function size($filePath = false) {
        $filePath = $this->pwd($filePath);
        if ($this->exists($filePath))
            return filesize($filePath);
        else
            return false;
    }

    /**
     * change the file permission
     * @param string $filePath file to check.
     * @return void
     */
    public function chmod($filePath, $mode = '0644') {
        $filePath = $this->pwd($filePath);
        @chmod($filePath, $mode);
    }

}

?>
