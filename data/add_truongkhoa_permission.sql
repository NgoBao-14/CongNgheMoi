-- Thêm quyền Trưởng khoa vào bảng phanquyen
INSERT INTO `phanquyen` (`idpq`, `PhanQuyen`) VALUES (3, 'Trưởng khoa');

-- Tạo bảng truongkhoa (tương tự như giangvien và sinhvien)
CREATE TABLE IF NOT EXISTS `truongkhoa` (
  `iduser` int(11) UNSIGNED NOT NULL,
  `MaTK` int(11) NOT NULL,
  `IDNganh` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`iduser`),
  FOREIGN KEY (`IDNganh`) REFERENCES `chuyennganh`(`IDNganh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Thêm tài khoản Trưởng khoa mẫu (username: truongkhoa, password: 123456)
INSERT INTO `taikhoan` (`username`, `password`, `PQ`) VALUES ('truongkhoa', 'e10adc3949ba59abbe56e057f20f883e', '3');

-- Lấy iduser vừa tạo và thêm thông tin user
SET @last_id = LAST_INSERT_ID();

INSERT INTO `user` (`iduser`, `HoDem`, `Ten`, `IDNganh`, `SDT`, `Email`) 
VALUES (@last_id, 'Trần Văn', 'A', 1, '0901234567', 'truongkhoa@gmail.com');

INSERT INTO `truongkhoa` (`iduser`, `MaTK`, `IDNganh`) 
VALUES (@last_id, 10001, 1);
