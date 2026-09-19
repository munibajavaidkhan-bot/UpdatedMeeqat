const sqlite = require('node:sqlite');
const db = new sqlite.DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', {open: true, readOnly: true});

// Get the last 5 messages from the distill session to see the final output
const sessionId = 'ses_08a438556ffe1jOJK40v5HHaFc';
const messages = db.prepare(`
  SELECT m.id, m.agent_id, m.time_created, m.data
  FROM message m
  WHERE m.session_id = ? AND json_extract(m.data, '$.role') = 'assistant'
  ORDER BY m.time_created DESC
  LIMIT 5
`).all(sessionId);

for (const msg of messages.reverse()) {
  const mData = JSON.parse(msg.data);
  const time = new Date(msg.time_created).toISOString();
  console.log(`\n--- assistant at ${time} ---`);
  
  const parts = db.prepare(`
    SELECT p.data
    FROM part p
    WHERE p.message_id = ?
    ORDER BY p.time_created
  `).all(msg.id);

  for (const part of parts) {
    const pData = JSON.parse(part.data);
    if (pData.type === 'text') {
      console.log(pData.text);
    }
  }
}

console.log('\n\n========== PORTFOLIO SESSION ==========\n');
const portfolioId = 'ses_08a464c34ffeHEqS5TL8HLPEjM';
const portfolioMessages = db.prepare(`
  SELECT m.id, m.agent_id, m.time_created, m.data
  FROM message m
  WHERE m.session_id = ?
  ORDER BY m.time_created
`).all(portfolioId);

for (const msg of portfolioMessages) {
  const mData = JSON.parse(msg.data);
  const role = mData.role;
  const time = new Date(msg.time_created).toISOString();
  console.log(`\n--- ${role} at ${time} ---`);
  
  const parts = db.prepare(`
    SELECT p.data
    FROM part p
    WHERE p.message_id = ?
    ORDER BY p.time_created
  `).all(msg.id);

  for (const part of parts) {
    const pData = JSON.parse(part.data);
    if (pData.type === 'text') {
      console.log(pData.text.substring(0, 3000));
    } else if (pData.type === 'tool') {
      const toolName = pData.tool || 'unknown';
      const input = JSON.stringify(pData.state?.input || {}).substring(0, 300);
      console.log(`[TOOL: ${toolName}] INPUT: ${input}`);
    }
  }
}

db.close();
