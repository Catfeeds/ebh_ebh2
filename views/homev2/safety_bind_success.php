<html>
    <body>
         
         <script type="text/javascript">

                function refreshParent(){
                    window.opener.location.href = window.opener.location.href;
                    if (window.opener.progressWindow){
                        window.opener.progressWindow.close();
                    }
                    window.close();
                }
                refreshParent();
         </script>
    </body>
</html>