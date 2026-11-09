import fs from 'fs';
import path from 'path';

const distDir = path.resolve('dist');
const publicDir = path.resolve('public');

// Ensure dist directory exists
if (!fs.existsSync(distDir)) {
  fs.mkdirSync(distDir, { recursive: true });
}

// Copy to dist
if (fs.existsSync('index.html')) {
  fs.copyFileSync('index.html', path.join(distDir, 'index.html'));
  if (fs.existsSync(publicDir)) {
    fs.copyFileSync('index.html', path.join(publicDir, 'index.html'));
  }
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

console.log('✅ ToonInput 2.0 built successfully for Vercel (Root, Dist & Public synced).');
