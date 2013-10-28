So your problem due to the combination of using absolute paths and loading the document using $dompdf->load_html(). Since dompdf knows nothing about where the document comes from it assumes that you're working from the local file system. As such, an absolute path will point to the root of the hard drive not the root of the web site. There are a few ways to fix your problem:

    Prepend $_SERVER['DOCUMENT_ROOT'] to any file reference.
    Set DOMPDF_ENABLE_REMOTE to true and prepend 'http://'.$_SERVER['HTTP_HOST'] to any file reference.
    Make any file reference relative to the currently executing PHP document
