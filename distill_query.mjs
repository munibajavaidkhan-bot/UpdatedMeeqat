import { DatabaseSync } from 'node:sqlite';
import { readFileSync } from 'fs';

const db = new DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', { readOnly: true });

// 1. List tables
const tables = db.prepare("SELECT name FROM sqlite_master WHERE type='table'").all();
console.log('=== TABLES ===');
tables.forEach(t => console.log(t.name));

// 2. List all sessions
console.log('\n=== SESSIONS ===');
try {
  const sessions = db.prepare("SELECT id, time_created, data FROM session ORDER BY time_created DESC LIMIT 20").all();
  sessions.forEach(s => {
    const data = JSON.parse(s.data);
    console.log(`${s.id} | created: ${new Date(Number(s.time_created)).toISOString()} | title: ${data.title || 'N/A'} | dir: ${data.directory || 'N/A'}`);
  });
} catch(e) { console.log('Error:', e.message); }

// 3. Session count
console.log('\n=== SESSION COUNT ===');
try {
  const count = db.prepare("SELECT COUNT(*) as cnt FROM session").get();
  console.log('Total sessions:', count.cnt);
} catch(e) { console.log('Error:', e.message); }

// 4. Recent messages per session
console.log('\n=== RECENT MESSAGES ===');
try {
  const messages = db.prepare(`
    SELECT m.id, m.session_id, m.time_created, json_extract(m.data, '$.role') as role
    FROM message m
    ORDER BY m.time_created DESC
    LIMIT 30
  `).all();
  messages.forEach(m => {
    console.log(`msg:${m.id} | ses:${m.session_id} | ${new Date(Number(m.time_created)).toISOString()} | ${m.role}`);
  });
} catch(e) { console.log('Error:', e.message); }

db.close();
