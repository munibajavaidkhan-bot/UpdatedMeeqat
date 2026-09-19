const sqlite = require('node:sqlite');
const db = new sqlite.DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', {open: true, readOnly: true});

// Get ALL content from the Admin dashboard session
const sessionId = 'ses_08a43867dffeaHdOMQwGp6lEUA';
const messages = db.prepare(`
  SELECT m.id, m.time_created, m.data
  FROM message m
  WHERE m.session_id = ?
  ORDER BY m.time_created
`).all(sessionId);

for (const msg of messages) {
  const mData = JSON.parse(msg.data);
  const time = new Date(msg.time_created).toISOString();
  console.log(`\n=== ${mData.role.toUpperCase()} at ${time} ===`);
  
  const parts = db.prepare(`
    SELECT p.data
    FROM part p
    WHERE p.message_id = ?
    ORDER BY p.time_created
  `).all(msg.id);

  for (const part of parts) {
    const pData = JSON.parse(part.data);
    if (pData.type === 'text') {
      console.log(`TEXT: ${pData.text.substring(0, 5000)}`);
    } else if (pData.type === 'tool') {
      const toolName = pData.tool || 'unknown';
      const input = JSON.stringify(pData.state?.input || {}).substring(0, 1000);
      const output = JSON.stringify(pData.state?.output || '').substring(0, 2000);
      console.log(`TOOL: ${toolName}`);
      console.log(`  INPUT: ${input}`);
      console.log(`  OUTPUT: ${output}`);
    } else if (pData.type === 'reasoning') {
      console.log(`REASONING: ${pData.text.substring(0, 1000)}`);
    }
  }
}

db.close();
