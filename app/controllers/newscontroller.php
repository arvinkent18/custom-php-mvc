<?php
    require_once('app/config/database.php');

    class NewsController
    {
        private $db;

        function __construct()
        {
            $this->db = new Database();
        }

        /**
		 * Retrieves News list from database
		 *
		 * @access public
         * @return list
		 **/
        public function index()
        {
            $query = 'SELECT * FROM `news` ORDER BY id';
            
            return $this->db->baseQuery($query);
        }

        /**
		 * Store News record into database
		 *
		 * @param string $title
         * @param string $description
         * @param string $date
		 * @param string $source
		 * @access public
         * @return id
		 **/
        public function store($title, $description, $source, $url, $image) {
            $imagePath = 'public/images/';

            if (!empty($image['tmp_name'])) {
               $tmpName = $image['tmp_name'];
               $name = basename($image['name']);
               $ext = strtolower(substr($name, strripos($name, '.')+1));
               $imagePath .= round(microtime(true)).mt_rand() . '.' . $ext;
               $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
               $fileType =  finfo_file($fileInfo, $tmpName);
               if ($fileType == 'image/jpeg' || $fileType == 'image/png' || $fileType == 'image/jpg') {                  
                   if ($image['size'] > 16777216) {
                       return 1;
                   } else {
                       move_uploaded_file($tmpName, $imagePath);
                   }
               } else {
                   return 2;
               }
               finfo_close($fileInfo);
            } else {
                $imagePath = '';
            }
            
            $query = 'SELECT title FROM news WHERE title = ? LIMIT 1';
            $paramType = 's';
            $paramData = array(
                $title
            );

            $result = $this->db->runQuery($query, $paramType, $paramData);

            if (!empty($result)) {
                return 3;
            } else {
                $query = 'INSERT INTO news (`title`, `description`, `source`, `url`, `image`, `created_at`)';
                $query .= 'VALUES (?, ?, ?, ?, ?, ?)';
                $paramType = 'ssssss';
                $paramData = array(
                    $title,
                    $description,
                    $source,
                    $url,
                    $imagePath,
                    date('Y-m-d')
                );
    
                $result = $this->db->insert($query, $paramType, $paramData);

                if ($result) {
                    return 0;
                }
            }
        }
    }