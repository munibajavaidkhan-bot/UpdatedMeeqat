const sqlite = require('node:sqlite');
const db = new sqlite.DatabaseSync('C:\\Users\\FATTANI COMPUTERS\\.local\\share\\mimocode\\mimocode.db', {open: true, readOnly: true});

console.log("=== TABLE SCHEMAS ===");
const tables = ['session','project','message','part','task','task_event','actor_registry'];
for (const t of tables) {
  const rows = db.prepare("SELECT sql FROM sqlite_master WHERE type='table' AND name=?").all(t);
  if (rows.length) console.log(rows[0].sql + '\n');
}

console.log("=== RECENT SESSIONS ===");
const sessions = db.prepare("SELECT id, title, time_created, time_updated FROM session ORDER BY time_updated DESC LIMIT 20").all();
console.log(JSON.stringify(sessions, null, 2));

console.log("\n=== PROJECTS ===");
const projects = db.prepare("SELECT * FROM project LIMIT 10").all();
console.log(JSON.stringify(projects, null, 2));

console.log("\n=== MESSAGE COUNT PER SESSION ===");
const msgCounts = db.prepare("SELECT session_id, COUNT(*) as cnt FROM message GROUP BY session_id ORDER BY cnt DESC LIMIT 10").all();
console.log(JSON.stringify(msgCounts, null, 2));

console.log("\n=== TASKS ===");
const tasks = db.prepare("SELECT * FROM task LIMIT 20").all();
console.log(JSON.stringify(tasks, null, 2));

console.log("\n=== ACTOR_REGISTRY ===");
const actors = db.prepare("SELECT * FROM actor_registry LIMIT 20").all();
console.log(JSON.stringify(actors, null, 2));

db.close();
