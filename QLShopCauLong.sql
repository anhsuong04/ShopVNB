
CREATE DATABASE QLShopCauLong
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE QLShopCauLong;



-- Bảng Nhà Cung Cấp
CREATE TABLE NhaCungCap (
    MaNCC VARCHAR(20) PRIMARY KEY,
    TenNCC VARCHAR(50),
    SDT VARCHAR(15),
    DiaChi VARCHAR(200),
	Logo VARCHAR(255)
);

-- Bảng Loại Sản Phẩm
CREATE TABLE LoaiSanPham (
    MaLSP VARCHAR(20) PRIMARY KEY,
    TenLSP VARCHAR(100),
	MoTa TEXT
);

-- Bảng Sản Phẩm
CREATE TABLE SanPham (
    MaSP VARCHAR(50) PRIMARY KEY,
    TenSP VARCHAR(200) NOT NULL,
    MaLSP VARCHAR(20),
    MaNCC VARCHAR(20),
    GiaGoc DECIMAL(12,2),       
    GiaGiam DECIMAL(12,2),     
    MoTa TEXT,                 
    HinhAnh VARCHAR(255),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (MaLSP) REFERENCES LoaiSanPham(MaLSP),
    FOREIGN KEY (MaNCC) REFERENCES NhaCungCap(MaNCC)
);

CREATE TABLE Users (
    UserID VARCHAR(20) PRIMARY KEY,
    Ho VARCHAR(10),
	Ten VARCHAR(20), 
    Email VARCHAR(100) UNIQUE NOT NULL,
    MatKhau VARCHAR(50) NOT NULL,
    SDT VARCHAR(15),
    DiaChi VARCHAR(255),
    Role TINYINT NOT NULL, -- 1 = Admin, 2 = Staff, 3 = Customer
	Avatar VARCHAR(255),
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);




-- Bảng Hóa Đơn
CREATE TABLE HoaDon (
    MaHD VARCHAR(20) PRIMARY KEY,
    UserID VARCHAR(20),
    NgayLap DATETIME,
    TongTien DECIMAL(12,2),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);
CREATE TABLE KichCo (
  MaSize INT AUTO_INCREMENT PRIMARY KEY,
  TenSize VARCHAR(20) NOT NULL
);
-- Bảng Chi Tiết Hóa Đơn
CREATE TABLE ChiTietHoaDon (
    MaHD VARCHAR(20),
    MaSP VARCHAR(50),
    MaSize INT NULL, 
    SoLuong INT,
    DonGia DECIMAL(12,2),
    PRIMARY KEY (MaHD, MaSP),
    FOREIGN KEY (MaHD) REFERENCES HoaDon(MaHD),
    FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP),
    FOREIGN KEY (MaSize) REFERENCES KichCo(MaSize)
);


CREATE TABLE SanPham_KichCo (
  MaSP VARCHAR(10)   ,
  MaSize INT NULL,
  SoLuong INT DEFAULT 0,
  PRIMARY KEY (MaSP, MaSize),
  FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP),
  FOREIGN KEY (MaSize) REFERENCES KichCo(MaSize)
);



INSERT INTO NhaCungCap (MaNCC, TenNCC, SDT, DiaChi,Logo) VALUES
('NCC001', 'Yonex Việt Nam', '0901234567', '123 Trần Hưng Đạo NT','Yonex.jpg'),
('NCC002', 'Lining Việt Nam', '0905738112', '421 Hàn Thuyên Quận 7','Lining.jpg'),
('NCC003', 'Victor Việt Nam', '0908377474', '76 Thống Nhất Quận Tây Hồ','Victor.webp'),
('NCC004', 'Kumpoo Việt Nam', '090528747', '13 Bạch Đằng Quận 3','Kumpoo.jpg'),
('NCC005', 'Mizuno Việt Nam', '0901736882', '453 Hồng Bàng Quận Hoàng Kiếm','Mizuno.jpg'),
('NCC006', 'Apacs Việt Nam', '0903774781', '151 Lê Đại Hành Quận 2','Apacs.webp');


Insert into LoaiSanPham(MaLSP,TenLSP,MoTa) values
('LSP001','Vợt cầu lông','Chuyên cung cấp các dòng vợt cầu lông chính hãng từ Yonex, Lining, Victor... phù hợp cho người chơi từ mới bắt đầu đến vận động viên chuyên nghiệp. Hỗ trợ tư vấn chọn vợt theo lối đánh công, thủ, cân bằng.'),
('LSP002','Giày cầu lông','Giày cầu lông chính hãng với công nghệ giảm chấn, chống lật cổ chân, bám sân giúp di chuyển linh hoạt và an toàn. Có đầy đủ size, mẫu mới nhất từ Yonex, Kawasaki, Lining, Mizuno.'),
('LSP003','Áo cầu lông','Áo cầu lông chất liệu thoáng khí, thấm hút mồ hôi nhanh, co giãn 4 chiều. Nhiều mẫu mã đẹp, trẻ trung, phù hợp thi đấu và tập luyện từ các thương hiệu thể thao uy tín.'),
('LSP004','Quần cầu lông','Quần cầu lông co giãn tốt, form thể thao, thoải mái khi di chuyển và bật nhảy. Chất liệu mềm mịn, thoát mồ hôi, phù hợp thi đấu và tập luyện.'),
('LSP005','Váy cầu lông','Váy cầu lông thời trang thể thao dành cho nữ, thiết kế năng động, co giãn thoải mái, chất liệu thoáng khí. Nhiều mẫu đẹp, trẻ trung, phù hợp thi đấu và tập luyện.');

Insert into SanPham(MaSP,TenSP,MaLSP,MaNCC,GiaGoc,GiaGiam,MoTa,HinhAnh,NgayTao,NgayCapNhat) values
('VOT001','Vợt cầu lông Yonex Astrox 99 Play 2025','LSP001','NCC001',1769000,1500000,'Vợt cầu lông Yonex Astrox 99 Play 2025 dù là phiên bản tầm thấp nhất trong dòng vợt 99 2025 này, nhưng vợt vẫn được trang bị công nghệ sở hữu Rotational Generator System cải tiến, phân bổ trọng lượng trên đầu cán vợt, cho ra những pha tấn công liên tục.','VOT001.webp','2025-11-02 08:00:00',NOW()),
('VOT002','Vợt cầu lông Yonex Astrox 100 Game VA','LSP001','NCC001',2849000,2500000,'Vợt cầu lông Yonex Astrox 100 Game VA Lấy cảm hứng từ phiên bản cao cấp Astrox 100ZZ VA, cây vợt này được tinh chỉnh khéo léo mang đến sức mạnh tấn công vượt trội, dễ làm quen và đặc biệt có mức giá hợp lý hơn, phù hợp cho người chơi trình độ thấp hơn.','VOT002.webp','2025-11-02 08:00:00',NOW()),
('VOT003','Vợt cầu lông Yonex Arcsaber 0 Ability','LSP001','NCC001',579000,500000,' Vợt cầu lông Yonex Arcsaber 0 Ability là một trong những cây vợt thuộc phân khúc giá rẻ của thương hiệu Yonex, với chỉ số cân bằng cùng đũa vợt siêu dẻo cho khả năng hỗ trợ lực, hướng tới đối tượng là những bạn mới chơi thích lối đánh công thủ toàn diện.','VOT003.webp','2025-11-02 08:00:00',NOW()),
('VOT004','Vợt cầu lông Lining Halbertec 1000','LSP001','NCC002',880000,800000,'Vợt cầu lông Lining Halbertec 1000 tiếp nối sự thành công của các dòng vợt Lining Halbertec đang làm mưa làm gió trên thị trường cầu lông thời gian vừa qua.  Là cây vợt nằm trong phân khúc giá rẻ được ra mắt vào năm 2025 một chiến lược của thương hiệu','VOT004.webp','2025-11-02 08:00:00',NOW()),
('VOT005','Vợt cầu lông Lining Axforce 80 Light','LSP001','NCC002',4690000,4500000,'Vợt cầu lông Lining Axforce 80 Light sở hữu tông màu trắng chủ đạo, kết hợp với các chi tiết tinh tế tạo nên vẻ ngoài hiện đại, sang trọng. Thiết kế này không chỉ giúp vợt trở nên nổi bật hơn trên sân đấu mà còn tạo cảm giác thanh lịch.','VOT005.webp','2025-11-02 08:00:00',NOW()),
('VOT006','Vợt cầu lông Lining Axforce 90 New - Loh Kean Yew 2025','LSP001','NCC002',4349000,4100000,' Vợt cầu lông Lining Axforce 90 New - Loh Kean Yew 2025 là cây vợt cầu lông cao cấp thuộc dòng Axforce của thương hiệu Lining. Được thiết kế để tri ân những thành tựu và cống hiến của VĐV Loh Kean Yew.','VOT006.jpg','2025-11-02 08:00:00',NOW()),
('VOT007','Vợt cầu lông Victor DX-1 A','LSP001','NCC003',1450000,1000000,'Vợt cầu lông Victor DX-1 A mang đến hiệu suất toàn diện với khả năng kiểm soát và độ ổn định tuyệt vời. Độ cân bằng đồng đều và độ cong vừa phải của thân vợt mang đến sự kết hợp thoải mái giữa sức mạnh và khả năng điều khiển.','VOT007.webp','2025-11-02 08:00:00',NOW()),
('VOT008','Vợt cầu lông Victor TK Ultramanz','LSP001','NCC003',1790000,1500000,'Vợt Cầu Lông Victor TK Ultramanz là một dòng sản phẩm hợp tác giữa Victor và Ultraman, lấy cảm hứng từ nhân vật Ultraman Z. Dòng sản phẩm này bao gồm các dụng cụ thể thao như vợt, giày, túi và quần áo, được trang trí với các yếu tố của Ultraman.','VOT008.webp','2025-11-02 08:00:00',NOW()),
('VOT009','Vợt cầu lông Victor Thruster Shenron G – DragonBall Z 2025','LSP001','NCC003',3200000,3000000,'Vợt cầu lông Victor Thruster Shenron G – DragonBall Z 2025 đánh dấu sự hợp tác giữa thương hiệu Victor và bộ truyện tranh huyền thoại Dragon Ball Z nhằm tạo nên một sản phẩm mang tiếng vang lớn trong cộng đồng cầu lông.','VOT009.jpg','2025-11-02 08:00:00',NOW()),
('VOT010','Vợt Cầu Lông Kumpoo Flower Partner','LSP001','NCC004',620000,50000,'Vợt Cầu Lông Kumpoo Flower Partner được thiết kế có điểm cân bằng ở mức cân bằng, đũa cứng ở mức trung bình, trọng lượng 4U, dành cho những người chơi có lối đánh công thủ toàn diện, linh hoạt, có cổ tay chưa được tốt, đặc biệt là người mới.','VOT010.webp','2025-11-02 08:00:00',NOW()),
('VOT011','Vợt Cầu Lông Kumpoo Sakura','LSP001','NCC004',650000,600000,'Vợt Cầu Lông Kumpoo Sakura mang thông số dễ chơi và dễ làm quen với điểm cân bằng 295 +-5mm, đũa cứng ở mức trung bình, được dành cho lối chơi công thủ toàn diện, hơi thiên công với màu sắc trắng hồng tươi sáng lấy cảm hứng từ hoa anh đào.','VOT011.webp','2025-11-02 08:00:00',NOW()),
('VOT012','Vợt cầu lông Kumpoo Lush Moutain','LSP001','NCC004',990000,900000,'Vợt cầu lông Kumpoo Lush Moutain là mẫu vợt mới dễ chơi, phù hợp với đa số mọi người chơi với thông số 4U cùng độ nặng đầu 298+-5mm thuộc lối chơi công thủ toàn diện theo hướng hơi thiên công, Kumpoo Lush Moutain được biến thể với 2 phiên bản màu.','VOT012.webp','2025-11-02 08:00:00',NOW()),
('VOT013','Vợt cầu lông Mizuno Prototype X-3D','LSP001','NCC005',2629000,2500000,'Vợt cầu lông Mizuno Prototype X-3D thuộc phân khúc dòng vợt cao cấp của thương hiệu Mizuno, được trang bị thêm công nghệ High Foam System giúp vợt chống rung tốt hơn và hỗ trợ tăng lực hơn cho ra những cú đánh mạnh mẽ.','VOT013.jpg','2025-11-02 08:00:00',NOW()),
('VOT014','Vợt cầu lông Mizuno Caliber S-Pro','LSP001','NCC005',2542000,2500000,'Vợt cầu lông Mizuno Caliber S-Pro với thông số trọng lượng 4U, điểm cân bằng Nặng Đầu, thân vợt có độ Cứng ở mức Trung Bình kết hợp cùng dòng vợt Caliber Series cho độ ổn định cùng chính xác cực cao trên từng đường cầu hoàn hảo.','VOT014.webp','2025-11-02 08:00:00',NOW()),
('VOT015','Vợt cầu lông Mizuno Carbo Pro 839','LSP001','NCC005',1040000,900000,'Vợt cầu lông Mizuno Carbo Pro 839 là mẫu vợt trong dòng Carbo Pro nổi bật của Mizuno – tối ưu cho người chơi phong trào và trung cấp cần sự kết hợp giữa tốc độ swing nhẹ, trợ lực ổn định và độ chính xác cao.','VOT015.webp','2025-11-02 08:00:00',NOW()),
('VOT016','Vợt cầu lông Apacs Fantala Pro 101','LSP001','NCC006',250000,200000,'Vợt cầu lông Apacs Fantala Pro 101 có thông số cân bằng hơi nặng đầu, thích hợp cho lối đánh công thủ toàn diện hơi thiên về tấn công,vợt hỗ trợ có thể linh hoạt trong các pha cầu.','VOT016.webp','2025-11-02 08:00:00',NOW()),
('VOT017','Vợt cầu lông Apacs Blizzard Pro New','LSP001','NCC006',2500000,2000000,'Vợt cầu lông Apacs Blizzard Pro New thuộc phân khúc cao cấp, hướng đến đối tượng người chơi yêu thích lối đánh tấn công. Đũa cứng ở mức trung bình, trọng lượng 3U, đòi hỏi người chơi phải có lực tay khỏe và trình độ trung bình khá.','VOT017.webp','2025-11-02 08:00:00',NOW()),
('VOT018','Vợt cầu lông Apacs Honor Pro New','LSP001','NCC006',2500000,2000000,'Vợt cầu lông Apacs Honor Pro New thuộc phân khúc cao cấp với phiên bản màu sắc hoàn toàn mới so với phiên bản cũ 2023. Màu sắc được phối bởi màu đen tạo nên sự mạnh mẽ cho cây vợt kết hợp với các chi tiết xanh lá nổi bật.','VOT018.webp','2025-11-02 08:00:00',NOW()),
('GIAY001','Giày cầu lông Lining AYTV029-1','LSP002','NCC002',1130000,1000000,'Giày cầu lông Lining AYTV029-1 được thiết kế theo phong cách thể thao đậm chất nam tính. Phom dáng chắc chắn, ôm gọn bàn chân giúp gia tăng khả năng kiểm soát trong từng pha di chuyển. Màu sắc phối hợp tinh tế giữa các tông trung tính','GIAY001.webp','2025-11-02 08:00:00',NOW()),
('GiAY002','Giày cầu lông Yonex SHB 65X VA - Grayish Beige','LSP002','NCC001',1809000,1500000,'Giày cầu lông Yonex SHB 65X VA - Grayish Beige mang đậm dấu ấn của Viktor Axelsen với phối màu trắng xanh nổi bật, thể hiện phong cách thi đấu bùng nổ, mạnh mẽ nhưng đòi hỏi độ ổn định tối đa. Thân giày sử dụng da tổng hợp.','GIAY002.webp','2025-11-02 08:00:00',NOW()),
('GIAY003','Giày cầu lông Victor A770 F/T','LSP002','NCC003',1730000,1500000,'Giày cầu lông Victor A770 F/T là mẫu giày cầu lông dành cho người chơi năng động, được thiết kế để mang lại cảm giác thoải mái, độ bám sân tốt và khả năng bảo vệ chân tối đa. Giày có kiểu dáng thể thao hiện đại, phối màu nổi bật.','GIAY003.webp','2025-11-02 08:00:00',NOW()),
('GIAY004','Giày cầu lông Lining AYTT001-6','LSP002','NCC002',1200000,1000000,'Giày cầu lông Lining AYTT001-6 sử dụng màu sắc đơn giản và giản dị. Phần trên được làm từ chất liệu thoải mái, dễ chịu và mềm mại, mang lại cảm giác chân tốt. Thiết kế logo thương hiệu Li Ning, tay nghề tỉ mỉ.','GIAYT004.webp','2025-11-02 08:00:00',NOW()),
('GIAY005','Giày cầu lông Lining AYZV001-2','LSP002','NCC002',2190000,2000000,'Giày cầu lông Lining AYZV001-2 là dòng giày cầu lông cao cấp được phát triển dành riêng cho các tay vợt nữ. Sở hữu gam màu trắng - xanh pastel - hồng nhẹ, đôi giày mang đến cảm giác trẻ trung, hiện đại nhưng vẫn giữ nét tinh tế.','GIAY005.webp','2025-11-02 08:00:00',NOW()),
('GIAY006','Giày cầu lông Lining AYTV015-3','LSP002','NCC002',1200000,1000000,'Giày cầu lông Lining AYTV015-3 là một đôi giày tập luyện cầu lông đa năng, được thiết kế để mang lại sự thoải mái và ổn định cho người chơi. Thiết kế chống va chạm ở ngón chân giúp giảm trầy xước hoặc va chạm ở ngón chân và bảo vệ từng bước đi.','GIAY006.webp','2025-11-02 08:00:00',NOW()),
('GIAY007','Giày cầu lông Lining AYTU001-9','LSP002','NCC002',1200000,1000000,'Giày cầu lông Lining AYTU001-9 được thiết kế với tông màu đơn giản, mang phong cách tối giản và casual. Upper làm từ Synthetic leather mềm mại, tạo cảm giác thoải mái cho bàn chân. Logo thương hiệu Li-Ning trên thân giày cùng đường may tinh xảo.','GIAY007.webp','2025-11-02 08:00:00',NOW()),
('GIAY008','Giày cầu lông Lining AYTU001-8','LSP002','NCC002',1200000,1000000,'Giày cầu lông Lining AYTU001-8 là phiên bản nâng cấp vượt trội thuộc dòng ALMIGHTY, được thiết kế dành riêng cho những vận động viên và người chơi yêu cầu sự ổn định, tốc độ và độ bền cao. Với những cải tiến nổi bật về công nghệ đệm.','GIAY008.webp','2025-11-02 08:00:00',NOW()),
('GIAY009','Giày cầu lông Lining AYTV027-1','LSP002','NCC002',1219000,1000000,'Giày cầu lông Lining AYTV027-1 sử dụng màu sắc đơn giản và giản dị. Phần trên được làm từ chất liệu thoải mái, dễ chịu và mềm mại, mang lại cảm giác chân tốt. Thiết kế chống va chạm của mũi giày giúp giảm trầy xước hoặc va chạm trên ngón chân.','GIAY009.webp','2025-11-02 08:00:00',NOW()),
('GIAY010','Giày cầu lông Victor A370 AC','LSP002','NCC003',1480000,1300000,'Giày cầu lông Victor A370 AC được thiết kế để nhẹ, thoáng khí, chống trượt và hấp thụ sốc, phù hợp cho cả nam và nữ, với công nghệ cốt lõi trong giày cầu lông Victor là Energy Max 3.0, được cải tiến từ phiên bản 2.0, giúp hấp thụ sốc.','GIAY010.webp','2025-11-02 08:00:00',NOW()),
('AO001','Áo cầu lông Yonex TPM2969 - Patrior Blue','LSP003','NCC001',279000,200000,'Áo được thiết kế chuyên dụng cho người chơi thể thao, đặc biệt là bộ môn cầu lông, mang lại cảm giác thoáng mát, linh hoạt và thoải mái trong suốt quá trình vận động. Áo được may từ chất liệu vải thun co giãn 4 chiều.','AO001.webp','2025-11-02 08:00:00',NOW()),
('AO002','Áo cầu lông Yonex TRM2968 - Teal Green','LSP003','NCC001',219000,200000,'Áo được thiết kế chuyên dụng cho người chơi thể thao, đặc biệt là bộ môn cầu lông, mang lại cảm giác thoáng mát, linh hoạt và thoải mái trong suốt quá trình vận động. Áo được may từ chất liệu vải thun co giãn 4 chiều.','AO002.webp','2025-11-02 08:00:00',NOW()),
('AO003','Áo cầu lông Yonex TRM2968 - Glacier Gray','LSP003','NCC001',219000,200000,'Áo được thiết kế chuyên dụng cho người chơi thể thao, đặc biệt là bộ môn cầu lông, mang lại cảm giác thoáng mát, linh hoạt và thoải mái trong suốt quá trình vận động. Áo được may từ chất liệu vải thun co giãn 4 chiều.','AO003.webp','2025-11-02 08:00:00',NOW()),
('AO004','Áo cầu lông Yonex TRM2968 - Lemon Zest','LSP003','NCC001',219000,200000,'Áo được thiết kế chuyên dụng cho người chơi thể thao, đặc biệt là bộ môn cầu lông, mang lại cảm giác thoáng mát, linh hoạt và thoải mái trong suốt quá trình vận động. Áo được may từ chất liệu vải thun co giãn 4 chiều.','AO004.webp','2025-11-02 08:00:00',NOW()),
('AO005','Áo cầu lông Yonex TRM2967 - Light Taupe','LSP003','NCC002',219000,200000,'Áo được thiết kế chuyên dụng cho người chơi thể thao, đặc biệt là bộ môn cầu lông, mang lại cảm giác thoáng mát, linh hoạt và thoải mái trong suốt quá trình vận động. Áo được may từ chất liệu vải thun co giãn 4 chiều.','AO005.webp','2025-11-02 08:00:00',NOW()),
('QUAN001','Quần cầu lông Lining 967 - Xanh navy','LSP004','NCC002',130000,100000,'Quần cầu lông được thiết kế chuyên biệt cho vận động thể thao, mang đến sự thoải mái, linh hoạt và bền bỉ trong từng pha di chuyển. Sản phẩm sử dụng chất liệu vải thun cao cấp, có khả năng co giãn 4 chiều.','QUAN001.webp','2025-11-02 08:00:00',NOW()),
('QUAN002','Quần cầu lông Lining 967 - Trắng','LSP004','NCC002',130000,100000,'Quần cầu lông được thiết kế chuyên biệt cho vận động thể thao, mang đến sự thoải mái, linh hoạt và bền bỉ trong từng pha di chuyển. Sản phẩm sử dụng chất liệu vải thun cao cấp, có khả năng co giãn 4 chiều.','QUAN002.webp','2025-11-02 08:00:00',NOW()),
('QUAN003','Quần cầu lông Lining 92009 - Trắng đỏ','LSP004','NCC002',130000,100000,'Quần cầu lông được thiết kế chuyên biệt cho vận động thể thao, mang đến sự thoải mái, linh hoạt và bền bỉ trong từng pha di chuyển. Sản phẩm sử dụng chất liệu vải thun cao cấp, có khả năng co giãn 4 chiều.','QUAN003.webp','2025-11-02 08:00:00',NOW()),
('QUAN004','Quần cầu lông Yonex TSM2844 - Naval Academy','LSP004','NCC001',219000,200000,'Quần cầu lông được thiết kế chuyên biệt cho vận động thể thao, mang đến sự thoải mái, linh hoạt và bền bỉ trong từng pha di chuyển. Sản phẩm sử dụng chất liệu vải thun cao cấp, có khả năng co giãn 4 chiều.','QUAN004.webp','2025-11-02 08:00:00',NOW()),
('QUAN005','Quần cầu lông Yonex TSM2913 - Jet Black','LSP004','NCC001',179000,200000,'Quần cầu lông được thiết kế chuyên biệt cho vận động thể thao, mang đến sự thoải mái, linh hoạt và bền bỉ trong từng pha di chuyển. Sản phẩm sử dụng chất liệu vải thun cao cấp, có khả năng co giãn 4 chiều.','QUAN005.webp','2025-11-02 08:00:00',NOW()),
('VAY001','Váy cầu lông Yonex TSI2846 - Naval Academy','LSP005','NCC001',279000,250000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY001.webp','2025-11-02 08:00:00',NOW()),
('VAY002','Váy cầu lông Yonex TSI2846 - Hemlock','LSP005','NCC001',279000,200000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY002.webp','2025-11-02 08:00:00',NOW()),
('VAY003','Váy cầu lông Lining 9861 - Trắng','LSP005','NCC002',150000,100000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY003.webp','2025-11-02 08:00:00',NOW()),
('VAY004','Váy cầu lông Lining 9019 - Trắng','LSP005','NCC002',150000,100000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY004.webp','2025-11-02 08:00:00',NOW()),
('VAY005','Váy cầu lông Victor TCV2361 - Đen','LSP005','NCC003',140000,100000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY005.webp','2025-11-02 08:00:00',NOW()),
('VAY006','Váy cầu lông Lining 9019 - Đen','LSP005','NCC002',279000,200000,'Váy cầu lông được thiết kế dành riêng cho các vận động viên nữ yêu thích sự năng động và nữ tính trên sân đấu. Sản phẩm được làm từ chất liệu vải thun co giãn 4 chiều, mềm mại, thoáng khí và thấm hút mồ hôi hiệu quả, giúp người mặc luôn thoải mái.','VAY006.webp','2025-11-02 08:00:00',NOW());

INSERT INTO Users (UserID, Ho, Ten, Email, MatKhau, SDT, DiaChi, Role, Avatar) VALUES
('U001', 'Admin',' ', 'admin@shop.com', '123456', '0900000001', 'VN', 1,'default.jpg'),
('U002', 'Võ','Khang', 'khang@gmail.com', '123456', '0835838185', 'Nha Trang', 3,'default.jpg'),
('U003', 'Ánh', 'Sương', 'suong@gmail.com', '123456', '0831234567', 'Sài Gòn', 3,'default.jpg'),
('U004', ' Thiện','Tùng', 'tung@gmail.com', '123456', '0838765432', 'Hà Nội', 2,'default.jpg');

INSERT INTO KichCo (TenSize) VALUES
('S'),
('M'),
('L'),
('XL'),
('28'),
('29'),
('30'),
('31'),
('32'),
('33'),
('37'),
('38'),
('39'),
('40'),
('41'),
('Free Size'),
('NoSize');

INSERT INTO SanPham_KichCo (MaSP, MaSize, SoLuong) VALUES
('AO001', 1, 10), ('AO001', 2, 8), ('AO001', 3, 6), ('AO001', 4, 5),
('AO002', 1, 8), ('AO002', 2, 7), ('AO002', 3, 5), ('AO002', 4, 4),
('AO003', 1, 9), ('AO003', 2, 8), ('AO003', 3, 6), ('AO003', 4, 5),
('AO004', 1, 7), ('AO004', 2, 6), ('AO004', 3, 4), ('AO004', 4, 3),
('AO005', 1, 10), ('AO005', 2, 8), ('AO005', 3, 7), ('AO005', 4, 5),
('QUAN001', 5, 6), ('QUAN001', 6, 5), ('QUAN001', 7, 4), ('QUAN001', 8, 3), ('QUAN001', 9, 2),
('QUAN002', 5, 8), ('QUAN002', 6, 7), ('QUAN002', 7, 5), ('QUAN002', 8, 4), ('QUAN002', 9, 3),
('QUAN003', 5, 6), ('QUAN003', 6, 5), ('QUAN003', 7, 4), ('QUAN003', 8, 3), ('QUAN003', 9, 2),
('QUAN004', 5, 5), ('QUAN004', 6, 5), ('QUAN004', 7, 4), ('QUAN004', 8, 3), ('QUAN004', 9, 2),
('QUAN005', 5, 7), ('QUAN005', 6, 6), ('QUAN005', 7, 4), ('QUAN005', 8, 3), ('QUAN005', 9, 2),
('GIAY001', 10, 5), ('GIAY001', 11, 5), ('GIAY001', 12, 4), ('GIAY001', 13, 4), ('GIAY001', 14, 3), ('GIAY001', 15, 2),
('GIAY002', 10, 6), ('GIAY002', 11, 6), ('GIAY002', 12, 5), ('GIAY002', 13, 5), ('GIAY002', 14, 4), ('GIAY002', 15, 3),
('GIAY003', 10, 4), ('GIAY003', 11, 4), ('GIAY003', 12, 3), ('GIAY003', 13, 3), ('GIAY003', 14, 2), ('GIAY003', 15, 1),
('GIAY004', 10, 6), ('GIAY004', 11, 5), ('GIAY004', 12, 4), ('GIAY004', 13, 4), ('GIAY004', 14, 3), ('GIAY004', 15, 3),
('GIAY005', 10, 5), ('GIAY005', 11, 4), ('GIAY005', 12, 4), ('GIAY005', 13, 3), ('GIAY005', 14, 2), ('GIAY005', 15, 2),
('VAY001', 16, 10),
('VAY002', 16, 8),
('VAY003', 16, 6),
('VAY004', 16, 7),
('VAY005', 16, 9),
('VOT001', 17, 10),
('VOT002', 17, 15),
('VOT003', 17, 12),
('VOT004',17, 8),
('VOT005', 17, 9),
('VOT006',17, 10),
('VOT007',17, 7),
('VOT008',17, 6),
('VOT009',17, 11),
('VOT010',17, 5),
('VOT011',17, 9),
('VOT012',17, 13),
('VOT013',17, 14),
('VOT014',17, 10),
('VOT015',17, 12),
('VOT016',17, 8),
('VOT017',17, 10),
('VOT018',17, 6);


INSERT INTO HoaDon (MaHD, UserID, NgayLap, TongTien) VALUES
('HD001','U002','2025-10-14 09:30:15',2969000),
('HD002','U003','2025-10-15 14:03:25',430000),
('HD003','U002','2025-10-12 10:30:00',2849000),
('HD004','U004','2025-10-13 16:50:12',837000),
('HD005','U002','2025-10-14 12:10:15',150000);


INSERT INTO ChiTietHoaDon (MaHD, MaSP, MaSize, SoLuong, DonGia) VALUES
('HD001','VOT001', NULL, 1, 1769000),    
('HD001','GIAY008', 14,   1, 1200000),   
('HD002','QUAN001', 5,    1, 130000),   
('HD002','VAY003', 16,    2, 150000),   
('HD003','VOT018', NULL,  1, 2500000),  
('HD003','QUAN002', 6,    1, 130000),   
('HD003','AO004', 4,      1, 219000),    
('HD004','VAY006', 16,    3, 279000),  
('HD005','VAY004', 16,    1, 150000);   
