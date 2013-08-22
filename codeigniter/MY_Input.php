<?php

class MY_Input extends CI_Input {

    var $delete;
    var $put;

    function MY_Input() {
        parent::CI_Input();

        if ($this->server('REQUEST_METHOD') == 'DELETE') {
            parse_str(file_get_contents('php://input'), $this->delete);

            $this->delete = $this->_clean_input_data($this->delete);
        } elseif ($this->server('REQUEST_METHOD') == 'PUT') {
            parse_str(file_get_contents('php://input'), $this->put);

            $this->put = $this->_clean_input_data($this->put);
        }
    }

    function delete($index = '', $xss_clean = FALSE) {
        return $this->_fetch_from_array($this->delete, $index, $xss_clean);
    }

    function put($index = '', $xss_clean = FALSE) {
        return $this->_fetch_from_array($this->put, $index, $xss_clean);
    }

    /**
     * Fetch an item from the php://input stream
     *
     * Useful when you need to access PUT, DELETE or PATCH request data.
     *
     * @param string $index Index for item to be fetched
     * @param bool $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    public function input_stream($index = '', $xss_clean = FALSE) {
// The input stream can only be read once, so we'll need to check
// if we have already done that first.
        if (is_array($this->_input_stream)) {
            return $this->_fetch_from_array($this->_input_stream, $index, $xss_clean);
        }

// Parse the input stream in our cache var
        parse_str(file_get_contents('php://input'), $this->_input_stream);
        if (!is_array($this->_input_stream)) {
            $this->_input_stream = array();
            return NULL;
        }

        return $this->_fetch_from_array($this->_input_stream, $index, $xss_clean);
    }

}
