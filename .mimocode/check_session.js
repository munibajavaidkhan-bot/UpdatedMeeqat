const sqlite = require('node:sqlite');
const db = new sqlite.DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', {open: true, readOnly: true});

const sessionId = process.argv[2];
const title = process.argv[3] || '';

console.log(`=== SESSION: ${title} (${sessionId}) ===\n`);

// Get all messages with their parts
const messages = db.prepare(`
  SELECT m.id, m.agent_id, m.time_created, m.data
  FROM message m
  WHERE m.session_id = ?
  ORDER BY m.time_created
`).all(sessionId);

for (const msg of messages) {
  const mData = JSON.parse(msg.data);
  const role = mData.role;
  const time = new Date(msg.time_created).toISOString();
  console.log(`--- ${role} [${msg.agent_id}] at ${time} ---`);

  // Get parts for this message
  const parts = db.prepare(`
    SELECT p.data, p.time_created
    FROM part p
    WHERE p.message_id = ?
    ORDER BY p.time_created
  `).all(msg.id);

  for (const part of parts) {
    const pData = JSON.parse(part.data);
    if (pData.type === 'text') {
      console.log(`TEXT: ${pData.text.substring(0, 2000)}`);
    } else if (pData.type === 'tool') {
      const toolName = pData.tool || 'unknown';
      const input = JSON.stringify(pData.state?.input || {}).substring(0, 500);
      const output = JSON.stringify(pData.state?.output || '').substring(0, 500);
      console.log(`TOOL: ${toolName}`);
      console.log(`  INPUT: ${input}`);
      console.log(`  OUTPUT: ${output}`);
    } else if (pData.type === 'step-start') {
      console.log(`[step-start]`);
    } else if (pData.type === 'step-finish') {
      console.log(`[step-finish] tokens=${pData.tokens || '?'}`);
    } else {
      console.log(`OTHER: ${JSON.stringify(pData).substring(0, 300)}`);
    }
    console.log('');
  }
  console.log('');
}

db.close();
