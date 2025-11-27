<?php
// Toast Helper for PHP
class ToastHelper {
    
    public static function success($message, $redirect = null) {
        $script = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Toast.success('".addslashes($message)."');
            });
        </script>";
        
        if ($redirect) {
            $script .= "<script>
                setTimeout(function() {
                    window.location.href = '$redirect';
                }, 1500);
            </script>";
        }
        
        echo $script;
    }
    
    public static function error($message, $redirect = null) {
        $script = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Toast.error('".addslashes($message)."');
            });
        </script>";
        
        if ($redirect) {
            $script .= "<script>
                setTimeout(function() {
                    window.location.href = '$redirect';
                }, 2000);
            </script>";
        }
        
        echo $script;
    }
    
    public static function warning($message, $redirect = null) {
        $script = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Toast.warning('".addslashes($message)."');
            });
        </script>";
        
        if ($redirect) {
            $script .= "<script>
                setTimeout(function() {
                    window.location.href = '$redirect';
                }, 1500);
            </script>";
        }
        
        echo $script;
    }
    
    public static function info($message, $redirect = null) {
        $script = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Toast.info('".addslashes($message)."');
            });
        </script>";
        
        if ($redirect) {
            $script .= "<script>
                setTimeout(function() {
                    window.location.href = '$redirect';
                }, 1500);
            </script>";
        }
        
        echo $script;
    }
}
?>
