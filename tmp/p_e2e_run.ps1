Set-Location $PSScriptRoot\..
try {
  $page = Invoke-WebRequest -Uri 'http://127.0.0.1:8899/tryon' -UseBasicParsing -TimeoutSec 60 -SessionVariable web
  $tok = [regex]::Match($page.Content, 'csrf-token" content="([^"]+)').Groups[1].Value
  "page OK, csrf token length: $($tok.Length)" | Out-File tmp\e2e_out.txt -Encoding utf8
  $capB64 = [Convert]::ToBase64String([IO.File]::ReadAllBytes((Join-Path $PWD 'public\images\caps\Kufi-removebg-preview.png')))
  $body = @{ model_image = "data:image/png;base64,$capB64"; item_id = 1; upload_mode = 'file'; extra_note = 'Kufi Cap' } | ConvertTo-Json -Depth 3
  $r = Invoke-WebRequest -Uri 'http://127.0.0.1:8899/tryon/prompt' -Method POST -Body $body -ContentType 'application/json' -Headers @{ 'X-CSRF-TOKEN' = $tok } -WebSession $web -UseBasicParsing -TimeoutSec 150
  $j = $r.Content | ConvertFrom-Json
  $j | ConvertTo-Json -Depth 4 | Out-File tmp\e2e_out.txt -Encoding utf8 -Append
} catch {
  "ERROR: $($_.Exception.Message)" | Out-File tmp\e2e_out.txt -Encoding utf8 -Append
} finally {
  Get-Process php -ErrorAction SilentlyContinue | Where-Object { $_.Id -ne $PID } | Stop-Process -ErrorAction SilentlyContinue
}
