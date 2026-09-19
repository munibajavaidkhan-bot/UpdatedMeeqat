try {
  $page = Invoke-WebRequest -Uri 'http://127.0.0.1:8895/tryon' -UseBasicParsing -TimeoutSec 60
  $c = $page.Content
  "HTTP $($page.StatusCode)" | Out-File tmp\page4_out.txt -Encoding utf8
  "helper:        " + ($c -match 'puterToDataUrl\(src') | Out-File tmp\page4_out.txt -Encoding utf8 -Append
  "person/cap:    " + (($c -match 'personData') -and ($c -match 'capData')) | Out-File tmp\page4_out.txt -Encoding utf8 -Append
  "new inputs:    " + ($c -match 'input_images: \[personData, capData\]') | Out-File tmp\page4_out.txt -Encoding utf8 -Append
  "old inputs gone: " + (-not ($c -match 'input_images: \[this\.userImage')) | Out-File tmp\page4_out.txt -Encoding utf8 -Append
  "model slug:    " + ($c -match 'gemini-3\.1-flash-image-preview') | Out-File tmp\page4_out.txt -Encoding utf8 -Append
} catch {
  "ERROR: $($_.Exception.Message)" | Out-File tmp\page4_out.txt -Encoding utf8
} finally {
  Get-Process php -ErrorAction SilentlyContinue | Stop-Process -ErrorAction SilentlyContinue
}
