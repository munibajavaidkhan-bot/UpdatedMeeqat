try {
  $page = Invoke-WebRequest -Uri 'http://127.0.0.1:8898/tryon' -UseBasicParsing -TimeoutSec 60
  "HTTP $($page.StatusCode)" | Out-File tmp\page_out.txt -Encoding utf8
  "puter.js script:  " + ($page.Content -match 'js\.puter\.com/v2')  | Out-File tmp\page_out.txt -Encoding utf8 -Append
  "demo card:        " + ($page.Content -match 'Puter\.js AI Demo')   | Out-File tmp\page_out.txt -Encoding utf8 -Append
  "puter methods:    " + ($page.Content -match 'runPuterDemo')          | Out-File tmp\page_out.txt -Encoding utf8 -Append
  "prompt route:     " + ($page.Content -match '/tryon/prompt')        | Out-File tmp\page_out.txt -Encoding utf8 -Append
  "footer powered:   " + ($page.Content -match 'Powered by Puter')     | Out-File tmp\page_out.txt -Encoding utf8 -Append
} catch {
  "ERROR: $($_.Exception.Message)" | Out-File tmp\page_out.txt -Encoding utf8
} finally {
  Get-Process php -ErrorAction SilentlyContinue | Stop-Process -ErrorAction SilentlyContinue
}
