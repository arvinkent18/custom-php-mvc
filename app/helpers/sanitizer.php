<?php

    class Sanitizer
    {
        public function clean(array $data)
        {
            $cleanedData = [];

            foreach ($data as $key => $value) {
                array_push($cleanedData, htmlspecialchars($value));
            }

            return $cleanedData;
        }
    }