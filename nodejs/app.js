// app.js

const express = require('express');
const bodyParser = require('body-parser');
const db = require('./db');
const karyawanRoutes = require('./routes/karyawan');

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use('/karyawan', karyawanRoutes);
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
