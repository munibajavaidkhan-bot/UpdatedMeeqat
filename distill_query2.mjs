import { DatabaseSync } from 'node:sqlite';

const db = new DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', { readOnly: true });

// 1. Session details
console.log('=== SESSION DETAILS ===');
const sessionCols = db.prepare("PRAGMA table_info(session)").all();
console.log('Session columns:', sessionCols.map(c => c.name).join(', '));
const sessions = db.prepare("SELECT * FROM session").all();
sessions.forEach(s => {
  console.log(JSON.stringify(s, null, 2));
});

// 2. Message details
console.log('\n=== MESSAGE COLUMNS ===');
const msgCols = db.prepare("PRAGMA table_info(message)").all();
console.log('Message columns:', msgCols.map(c => c.name).join(', '));

// 3. Get user messages with text
console.log('\n=== USER MESSAGES (with text) ===');
const userMsgs = db.prepare(`
  SELECT m.id, m.session_id, m.time_created
  FROM message m
  WHERE json_extract(m.data, '$.role') = 'user'
  ORDER BY m.time_created ASC
`).all();
console.log(`Total user messages: ${userMsgs.length}`);
userMsgs.forEach(m => {
  console.log(`  msg:${m.id} | ses:${m.session_id} | ${new Date(Number(m.time_created)).toISOString()}`);
});

// 4. Get user message text parts
console.log('\n=== USER MESSAGE TEXT PREVIEWS ===');
const userTextParts = db.prepare(`
  SELECT p.message_id, substr(json_extract(p.data, '$.text'), 1, 300) as text_preview
  FROM part p
  JOIN message m ON p.message_id = m.id
  WHERE json_extract(m.data, '$.role') = 'user'
    AND json_extract(p.data, '$.type') = 'text'
  ORDER BY m.time_created ASC
`).all();
userTextParts.forEach(p => {
  console.log(`  [${p.message_id}]: ${p.text_preview}`);
  console.log('---');
});

// 5. Tool usage patterns
console.log('\n=== TOOL USAGE (all sessions) ===');
const toolUsage = db.prepare(`
  SELECT json_extract(p.data, '$.tool') as tool,
         substr(json_extract(p.data, '$.state.input'), 1, 150) as input_preview,
         count(*) as n
  FROM message m
  JOIN part p ON p.message_id = m.id
  WHERE json_extract(m.data, '$.role') = 'assistant'
    AND json_extract(p.data, '$.type') = 'tool'
  GROUP BY tool, input_preview
  ORDER BY n DESC
  LIMIT 50
`).all();
toolUsage.forEach(t => {
  console.log(`  ${t.tool} (${t.n}x): ${t.input_preview}`);
});

// 6. Tasks
console.log('\n=== TASKS ===');
try {
  const tasks = db.prepare("SELECT * FROM task").all();
  console.log(`Total tasks: ${tasks.length}`);
  tasks.forEach(t => console.log(JSON.stringify(t, null, 2)));
} catch(e) { console.log('No task table or error:', e.message); }

// 7. Actor registry
console.log('\n=== ACTOR REGISTRY ===');
try {
  const actors = db.prepare("SELECT * FROM actor_registry").all();
  console.log(`Total actors: ${actors.length}`);
  actors.forEach(a => console.log(JSON.stringify(a)));
} catch(e) { console.log('No actors:', e.message); }

db.close();
