const sqlite = require('node:sqlite');
const db = new sqlite.DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', {open: true, readOnly: true});

// Get ALL text parts from the distill session
const sessionId = 'ses_08a438556ffe1jOJK40v5HHaFc';
const messages = db.prepare(`
  SELECT m.id, m.time_created, m.data
  FROM message m
  WHERE m.session_id = ?
  ORDER BY m.time_created
`).all(sessionId);

for (const msg of messages) {
  const mData = JSON.parse(msg.data);
  const time = new Date(msg.time_created).toISOString();
  
  const parts = db.prepare(`
    SELECT p.data
    FROM part p
    WHERE p.message_id = ?
    ORDER BY p.time_created
  `).all(msg.id);

  let hasText = false;
  for (const part of parts) {
    const pData = JSON.parse(part.data);
    if (pData.type === 'text' && pData.text && pData.text.trim().length > 10) {
      if (!hasText) {
        console.log(`\n--- ${mData.role} at ${time} ---`);
        hasText = true;
      }
      console.log(pData.text.substring(0, 5000));
    }
  }
}

db.close();
