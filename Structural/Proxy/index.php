<?php

class RemoteFile
{
    protected $_fileId = 0;
    protected $_filepath = "";
    protected $_filesize = 0;
    protected $_filename = "";
    protected $_filedata = null;

    public function loadById($fileId)
    {
        $this->_fileId = $fileId;
        $this->_loadFromDatabase($fileId);
        $this->_filedata = file_get_contents($this->_filepath);
    }

    public function _loadFromDatabase($fileId)
    {
        $fileinfo = DbAdapter::loadFileInfo($fileId);

        $this -> _filepath = $fileinfo['path'];
        $this -> _filesize = $fileinfo['size'];
        $this -> _filename = $fileinfo['name'];
    }

    public function getFileId()
    {
        return $this -> _fileId;
    }

    public function getFileContents()
    {
        return $this -> _filedata;
    }

    public function getFileSize()
    {
        return $this -> _filesize;
    }

    public function getFileName()
    {
        return $this -> _filename;
    }
}

class RemoteFileProxy extends RemoteFile
{
    public function loadById($fileId)
    {
        // Мы загружаем информацию только из БД, а сам файл не грузим
        $this -> _loadFromDatabase($fileId);
    }

    public function getFileContents()
    {
        if (null === $this -> _filedata) {
            $this -> _filedata = file_get_contents($this -> _filepath);
        }
        return $this -> _filedata;
    }
}

class RemoteFileExtendedProxy extends RemoteFileProxy
{
    protected $_realRemoteFile = null;
    /**
     * @var int
     */
    protected $_fileId = 0;
    
    public function loadById($fileId)
    {
        $this -> _fileId = $fileId;
    }
    public function getFileId()
    {
        return $this -> _getRealRemoteFile() -> getFileId();
    }
    public function getFileName()
    {
        return $this -> _getRealRemoteFile() -> getFileName();
    }
    public function getFileSize()
    {
        return $this -> _getRealRemoteFile() -> getFileSize();
    }
    public function getFileContents()
    {
        return $this -> _getRealRemoteFile() -> getFileContents();
    }
    /**
     * @return RemoteFileProxy
     */
    public function _getRealRemoteFile()
    {
        if (null == $this -> _realRemoteFile) {
            $this -> _realRemoteFile = new RemoteFileProxy();
            $this -> _realRemoteFile -> loadById($this -> _fileId);
        }
        return $this -> _realRemoteFile;
    }
}

