const express = require('express');
const router = express.Router();
const karyawanController = require('../controllers/karyawanController');

// Routes
router.post('/', karyawanController.addKaryawan);
router.get('/', karyawanController.getKaryawanList);
router.get('/:nik', karyawanController.getKaryawanDetail);
router.put('/:nik', karyawanController.updateKaryawan);
router.delete('/:nik', karyawanController.deleteKaryawan);

module.exports = router;
