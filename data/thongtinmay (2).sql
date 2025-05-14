-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 14, 2025 lúc 06:46 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thongtinmay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyennganh`
--

CREATE TABLE `chuyennganh` (
  `IDNganh` int(11) UNSIGNED NOT NULL,
  `ChuyenNganh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyennganh`
--

INSERT INTO `chuyennganh` (`IDNganh`, `ChuyenNganh`) VALUES
(1, 'Công nghệ thông tin'),
(2, 'Kỹ thuật phần mềm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detai`
--

CREATE TABLE `detai` (
  `IDDeTai` int(11) UNSIGNED NOT NULL,
  `TenDeTai` varchar(255) NOT NULL,
  `MoTa` varchar(255) NOT NULL,
  `IDGV` int(11) DEFAULT NULL,
  `ChuyenNganh` int(11) NOT NULL,
  `TrangThaiDeTai` varchar(255) NOT NULL DEFAULT 'Chưa được đăng ký',
  `NgayDK` date DEFAULT NULL,
  `TrangThaiDK` varchar(255) DEFAULT 'Chưa duyệt',
  `IDNhom` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `detai`
--

INSERT INTO `detai` (`IDDeTai`, `TenDeTai`, `MoTa`, `IDGV`, `ChuyenNganh`, `TrangThaiDeTai`, `NgayDK`, `TrangThaiDK`, `IDNhom`) VALUES
(1, 'Web tài xỉu', 'Dừng lại là thất bại', 3, 1, 'Chưa được đăng ký', NULL, 'Chưa duyệt', 1),
(2, 'Web cá độ', 'Cá độ là thú vui', 3, 2, 'Chưa được đăng ký', NULL, 'Chưa duyệt', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giangvien`
--

CREATE TABLE `giangvien` (
  `iduser` int(11) UNSIGNED NOT NULL,
  `MaGV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giangvien`
--

INSERT INTO `giangvien` (`iduser`, `MaGV`) VALUES
(3, 21003861);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhom`
--

CREATE TABLE `nhom` (
  `IDNhom` int(11) NOT NULL,
  `IDDeTai` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhom`
--

INSERT INTO `nhom` (`IDNhom`, `IDDeTai`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanquyen`
--

CREATE TABLE `phanquyen` (
  `idpq` int(10) UNSIGNED NOT NULL,
  `PhanQuyen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phanquyen`
--

INSERT INTO `phanquyen` (`idpq`, `PhanQuyen`) VALUES
(1, 'Giảng viên'),
(2, 'Sinh viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien`
--

CREATE TABLE `sinhvien` (
  `iduser` int(11) UNSIGNED NOT NULL,
  `MaSV` int(11) NOT NULL,
  `Lop` varchar(255) NOT NULL,
  `Diem` int(11) DEFAULT NULL,
  `IDNhom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sinhvien`
--

INSERT INTO `sinhvien` (`iduser`, `MaSV`, `Lop`, `Diem`, `IDNhom`) VALUES
(0, 25311987, 'ngubao', NULL, NULL),
(4, 21133, 'DHHTTT17A', 5, 1),
(7, 25054677, 'DHHTTT17B', NULL, NULL),
(8, 25980653, 'DHHTTT17C', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `iduser` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e',
  `PQ` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`iduser`, `username`, `password`, `PQ`) VALUES
(1, 'bao', 'e10adc3949ba59abbe56e057f20f883e', '4'),
(2, 'khuong', 'e10adc3949ba59abbe56e057f20f883e', '2'),
(3, '1', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(4, '25311987', 'e10adc3949ba59abbe56e057f20f883e', '2'),
(7, '25054677', 'e10adc3949ba59abbe56e057f20f883e', '2'),
(8, '25980653', 'e10adc3949ba59abbe56e057f20f883e', '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtin`
--

CREATE TABLE `thongtin` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenmay` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ram1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ram2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rom1` varchar(255) NOT NULL,
  `rom2` varchar(255) NOT NULL,
  `tencpu` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `iduser` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtin`
--

INSERT INTO `thongtin` (`id`, `tenmay`, `ram1`, `ram2`, `rom1`, `rom2`, `tencpu`, `os`, `iduser`) VALUES
(22, 'LaptopCuaBao', '410125E0', '7BAE0302', 'ACE4_2E00_1A5B_FC62_2EE4_AC00_0000_0001.', 'NULL', '11th Gen Intel(R) Core(TM) i5-11400H @ 2.70GHz', 'Windows', 1),
(23, 'LaptopCuaBao', '410125E0', '7BAE0302', 'ACE4_2E00_1A5B_FC62_2EE4_AC00_0000_0001.', 'NULL', '11th Gen Intel(R) Core(TM) i5-11400H @ 2.70GHz', 'Windows', 2),
(27, 'LaptopCuaBao', '410125E0', '7BAE0302', 'ACE4_2E00_1A5B_FC62_2EE4_AC00_0000_0001.', 'NULL', '11th Gen Intel(R) Core(TM) i5-11400H @ 2.70GHz', 'Windows', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `iduser` int(11) UNSIGNED NOT NULL,
  `HoDem` varchar(255) NOT NULL,
  `Ten` varchar(255) NOT NULL,
  `IDNganh` int(11) NOT NULL,
  `SDT` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`iduser`, `HoDem`, `Ten`, `IDNganh`, `SDT`, `Email`) VALUES
(1, '213', '213', 1, 'hoaibaojkl15@gmail.com', 'hoaibaojkl15@gmail.com'),
(3, 'Nguyễn Văn', 'D', 1, '0909090909', 'D@gmail.com'),
(4, 'Ngo8', 'Văn', 2, '112112', 'Van@gmail.com'),
(5, 'Đoàn', 'Khương', 1, '12312', 'k@gmail.com'),
(6, 'Nguyễn', 'Phúc', 2, '12', 'p@gmail.com'),
(7, 'Ngô Huỳnh', 'Bảo', 1, '0948520853', 'ngobao3861@gmail.com'),
(8, 'Đoàn Duy', 'Khương', 2, '0948520853', 'ngobao3861@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chuyennganh`
--
ALTER TABLE `chuyennganh`
  ADD PRIMARY KEY (`IDNganh`);

--
-- Chỉ mục cho bảng `detai`
--
ALTER TABLE `detai`
  ADD PRIMARY KEY (`IDDeTai`);

--
-- Chỉ mục cho bảng `giangvien`
--
ALTER TABLE `giangvien`
  ADD PRIMARY KEY (`iduser`);

--
-- Chỉ mục cho bảng `nhom`
--
ALTER TABLE `nhom`
  ADD PRIMARY KEY (`IDNhom`);

--
-- Chỉ mục cho bảng `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD PRIMARY KEY (`idpq`);

--
-- Chỉ mục cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`iduser`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`iduser`);

--
-- Chỉ mục cho bảng `thongtin`
--
ALTER TABLE `thongtin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chuyennganh`
--
ALTER TABLE `chuyennganh`
  MODIFY `IDNganh` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `detai`
--
ALTER TABLE `detai`
  MODIFY `IDDeTai` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nhom`
--
ALTER TABLE `nhom`
  MODIFY `IDNhom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phanquyen`
--
ALTER TABLE `phanquyen`
  MODIFY `idpq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `thongtin`
--
ALTER TABLE `thongtin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
