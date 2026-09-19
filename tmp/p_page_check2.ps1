try {
  $page = Invoke-WebRequest -Uri 'http://127.0.0.1:8897/tryon' -UseBasicParsing -TimeoutSec 60
  $c = $page.Content
  "HTTP $($page.StatusCode)" | Out-File tmp\page2_out.txt -Encoding utf8
  "new model slug:    " + ($c -match 'gemini-3\.1-flash-image-preview') | Out-File tmp\page2_out.txt -Encoding utf8 -Append
  "fallback model:    " + ($c -match 'gemini-2\.5-flash-image') | Out-File tmp\page2_out.txt -Encoding utf8 -Append
  "old provider gone: " + (-not ($c -match "provider: 'gemini'")) | Out-File tmp\page2_out.txt -Encoding utf8 -Append
} catch {
  "ERROR: $($_.Exception.Message)" | Out-File tmp\page2_out.txt -Encoding utf8
} finally {
  Get-Process php -ErrorAction SilentlyContinue | Stop-Process -ErrorAction SilentlyContinue
}
