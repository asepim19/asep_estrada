const db = require('../db');

exports.addKaryawan = async (req, res) => {
    try {
        const { nama, alamat, tgllahir, divisi, status } = req.body;

        const [results, fields] = await db.execute('CALL AddKaryawan(?, ?, ?, ?, ?)', [nama, alamat, tgllahir, divisi, status]);

        res.json({ message: 'Data added successfully', insertedId: results[0].insertedId });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Internal Server Error' });
    }
};

exports.getKaryawanList = async (req, res) => {
    try {
        const [results, fields] = await db.execute('CALL ListKaryawan()');
        res.json(results[0]);
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Internal Server Error' });
    }
};

exports.updateKaryawan = async (req, res) => {
    try {
        const { nama, alamat, tgllahir, divisi, status } = req.body;
        const { nik } = req.params;

        await db.execute('CALL EditKaryawan(?, ?, ?, ?, ?, ?)', [nik, nama, alamat, tgllahir, divisi, status]);

        res.json({ message: 'Data updated successfully' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Internal Server Error' });
    }
};

exports.deleteKaryawan = async (req, res) => {
    try {
        const { nik } = req.params;

        await db.execute('CALL DeleteKaryawan(?)', [nik]);

        res.json({ message: 'Data deleted successfully' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Internal Server Error' });
    }
};

exports.getKaryawanDetail = async (req, res) => {
    try {
      const { nik } = req.params;
  
      const [results, fields] = await db.execute('CALL GetKaryawanDetail(?)', [nik]);
  
      if (results[0].length === 0) {
        res.status(404).json({ message: 'Karyawan not found' });
      } else {
        const karyawan = results[0][0];
        res.json(karyawan);
      }
    } catch (error) {
      console.error(error);
      res.status(500).json({ message: 'Internal Server Error' });
    }
  };
  
