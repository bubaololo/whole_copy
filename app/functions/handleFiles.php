<?php


function getAllLocalPages()
{

}

function getHttpContent(string $url, int $maxRetries = 3)
{
    $options = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n",
        ),
    );
    $context = stream_context_create($options);
    
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        // throw new InvalidArgumentException("Invalid URL: $url");
        // return false;
        error_log("Incorrect src $url");
        echo "Incorrect src $url";
        return null;
    }
    $startTime = microtime(true); // Record start time
    $retryCount = 0;
    do {
        try {
            $raw = @file_get_contents($url, false, $context);
            if ($raw !== false) {
                break; // Break the loop if content is fetched successfully
            }
        } catch (Exception $e) {
            // Catch any exceptions during the file_get_contents attempt
            echo $e;
        }
        $retryCount++;
    } while ($retryCount < $maxRetries);
    
    if ($raw === false) {
        // throw new RuntimeException("Failed to fetch content from URL after $maxRetries retries.");
        // return false;
        error_log("Failed to fetch content from URL after $maxRetries retries.");
        echo "Failed to fetch content from URL after $maxRetries retries.";
        return null;
    }
    
    $endTime = microtime(true); // Record end time
    $duration = $endTime - $startTime; // Calculate duration in seconds
    
    echo "Content fetched in $duration seconds.\n";
    
    return $raw;
}


function getPageDom(string $url, int $maxRetries = 3): simple_html_dom
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new InvalidArgumentException("Invalid URL: $url");
        // return false;
    }
    $startTime = microtime(true); // Record start time
    $retryCount = 0;
    do {
        try {
            $phpdom = @file_get_html($url);
            if ($phpdom !== false) {
                break; // Break the loop if content is fetched successfully
            }
        } catch (Exception $e) {
            // Catch any exceptions during the file_get_contents attempt
        }
        $retryCount++;
    } while ($retryCount < $maxRetries);
    
    if ($phpdom === false) {
        throw new RuntimeException("Failed to fetch content from URL after $maxRetries retries.");
        // return false;
    }
    
    $endTime = microtime(true); // Record end time
    $duration = $endTime - $startTime; // Calculate duration in seconds
    
    echo "Content fetched in $duration seconds.\n";
    
    
    return $phpdom;
}