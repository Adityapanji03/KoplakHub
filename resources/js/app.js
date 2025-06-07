import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import Finance from './finance'; // Import komponen finance

// Render ke elemen dengan id 'app'
const container = document.getElementById('app');
const root = createRoot(container);
root.render(<Finance />);
