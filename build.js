import fs from 'fs';
import path from 'path';

const distDir = path.resolve('dist');

if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir, { recursive: true });
}

if (fs.existsSync('index.html')) {
  fs.copyFileSync('index.html', path.join(distDir, 'index.html'));
}

if (fs.existsSync('assets')) {
  fs.cpSync('assets', path.join(distDir, 'assets'), { recursive: true });
}

if (fs.existsSync('data')) {
  fs.cpSync('data', path.join(distDir, 'data'), { recursive: true });
}

if (fs.existsSync('vercel.json')) {
  fs.copyFileSync('vercel.json', path.join(distDir, 'vercel.json'));
}

console.log('✅ ToonInput 2.0 built successfully for Vercel (Root & Dist synced).');
