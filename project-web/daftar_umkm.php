<hr>
    
    <h3 class="mt-4">Daftar UMKM</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Usaha</th>
          <th>Pemilik</th>
          <th>Alamat</th>
          <th>Kontak</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_usaha']) ?></td>
              <td><?= htmlspecialchars($row['pemilik']) ?></td>
              <td><?= htmlspecialchars($row['alamat']) ?></td>
              <td><?= htmlspecialchars($row['kontak']) ?></td>
              <td>
                <a href="edit_umkm.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_umkm.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</a>
              </td>
            </tr>
            <?php
        }
        ?>
      </tbody>
    </table>
  </div>