class "InteractiveMap"
function InteractiveMap:__init()
    self.lastTime = os.time()

    Events:Subscribe("PostTick", self, self.PostTick)
    Events:Subscribe("PlayerChat", self, self.PlayerChat)
    Events:Subscribe("PlayerJoin", self, self.PlayerJoin)
    Events:Subscribe("PlayerQuit", self, self.PlayerQuit)
end

function InteractiveMap:PostTick(args)
    if os.difftime(os.time(), self.lastTime) >= 1 then
        self:WritePositions()
        self:ChatIn()
    end
end

function InteractiveMap:PlayerChat(args)
    if args.text:sub(1, 1) ~= "/" then
        file = io.open("chatout.txt", "a")
        out = "\n"..os.time()..","..args.player:GetName()..","..args.text
        file:write(out)
        file:close()
    end
end

function InteractiveMap:PlayerJoin(args)
    file = io.open("chatout.txt", "a")
    out = "\n"..os.time()..",Join,"..args.player:GetName().." joined"
    file:write(out)
    file:close()
end

function InteractiveMap:PlayerQuit(args)
    file = io.open("chatout.txt", "a")
    out = "\n"..os.time()..",Quit,"..args.player:GetName().." quit"
    file:write(out)
    file:close()
end

function InteractiveMap:WritePositions()
    file = io.open("intermap.txt", "w");
    out = ""
    for player in Server:GetPlayers() do
        local playerPos = player:GetPosition()
        out = out.."\n"..player:GetName()..","..playerPos.x..","..playerPos.z
    end
    file:write(out)
    file:close()
    self.lastTime = os.time()
end

function InteractiveMap:ChatIn()
    for line in io.lines("chatin.txt") do
        line = string.gsub(line, "\n", "");
        local time, name, msg = line:match("([^,]+),([^,]+),([^,]+)")
        Chat:Broadcast("WEB::"..name..": "..msg, Color(255, 255, 255))
    end
    file = io.open("chatin.txt", "w+")
    file:close()
end

im = InteractiveMap()